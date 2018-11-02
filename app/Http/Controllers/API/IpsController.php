<?php

namespace App\Http\Controllers\API;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests;
use App\Http\Transformers\BuildingTransformer;
use App\Http\Transformers\FloorTransformer;
use App\Http\Transformers\PointTransformer;
use App\Http\Transformers\Resource;
use App\Models\BluetoothSample;
use App\Models\Fingerprint;
use App\Models\Floor;
use App\Models\MagneticSample;
use App\Models\Point;
use App\Models\WifiSample;
use App\Http\Requests\SaveFingerprintsRequest;
use App\Http\Requests\GetLocationRequest;
use App\Http\Libraries\Vector;

/**
 * Class IpsController
 * @package App\Http\Controllers
 */
class IpsController extends ApiController
{
    /**
     * @param \App\Http\Requests\GetLocationRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLocation(GetLocationRequest $request)
    {
        /** @var Point $oldPoint */
        $oldPoint = null;
        if($request->has('point')){
            $oldPoint = Point::find(optimus_decode($request->input('point.id')));
        }

        $baseVector = new Vector($oldPoint);

        if($request->has('wifi')) {
            $baseVector->addWifiSamples($request->input('wifi'));
        }

        if($request->has('bluetooth')) {
            $baseVector->addBluetoothSamples($request->input('bluetooth'));
        }

        if($request->has('magnetic')) {
            $baseVector->addMagneticSamples($request->input('magnetic'));
        }

        /** @var Point $point */
        $point = null;
        if($oldPoint){
            // Research only in the current floor
            /** @var Collection $fingerprints */
            $fingerprints = $oldPoint->floor->fingerprints;
            $point = $this->getClosestPointFromBase($fingerprints, $baseVector, $request);
        }

        if(!$point) {
            // If nothing is found in the current floor, extend the research to the whole database
            $fingerprints = Fingerprint::all();
            $point = $this->getClosestPointFromBase($fingerprints, $baseVector, $request);
        }

        if($point) {
            //return $this->respond($point);
            $locationFound = [
                'building' => Resource::item($point->floor->building, new BuildingTransformer()),
                'floor'    => Resource::item($point->floor, new FloorTransformer()),
                'point'    => Resource::item($point, new PointTransformer())
            ];

            return $this->respond($locationFound);
        }

        // If the location could not be found
        return $this->respondNotFound("Location not found.");
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $fingerprints
     * @param \uKonect\Http\Libraries\Vector $baseVector
     *
     * @return null
     */
    private function getClosestPointFromBase(Collection $fingerprints, Vector $baseVector, GetLocationRequest $request, Point $oldPoint = null)
    {
        /** @var Collection $vectors */
        $vectors = collect();
        $wifiVectors = collect();
        $bluetoothVectors = collect();
        $magneticVectors = collect();

        foreach ($fingerprints as $fingerprint) {
            $vector = new Vector($fingerprint->point);
            $wifiVector = new Vector($fingerprint->point);
            $bluetoothVector = new Vector($fingerprint->point);
            $magneticVector = new Vector($fingerprint->point);

            if($request->has('wifi') && $fingerprint->wifiSamples->count()){
                $vector->addWifiSamples($fingerprint->wifiSamples->toArray(), $baseVector);
                $wifiVector->addWifiSamples($fingerprint->wifiSamples->toArray(), $baseVector);
            }

            if($request->has('bluetooth') && $fingerprint->bluetoothSamples->count()){
                $vector->addBluetoothSamples($fingerprint->bluetoothSamples->toArray(), $baseVector);
                $bluetoothVector->addBluetoothSamples($fingerprint->bluetoothSamples->toArray(), $baseVector);
            }

            if($request->has('magnetic') && $fingerprint->magneticSamples->count()){
                $vector->addMagneticSamples($fingerprint->magneticSamples->first()->toArray());
                $magneticVector->addMagneticSamples($fingerprint->magneticSamples->first()->toArray());
            }

            if(!$vector->isEmpty()) {
               // $vector->calculateEuclideanDistanceToBase($baseVector);
                $wifiVector->calculateEuclideanDistanceToBase($baseVector);
                $bluetoothVector->calculateEuclideanDistanceToBase($baseVector);
                $magneticVector->calculateEuclideanDistanceToBase($baseVector);

                $vectors->push($vector);
                $wifiVectors->push($wifiVector);
                $bluetoothVectors->push($bluetoothVector);
                $magneticVectors->push($magneticVector);
            }
        }

        // Sort vectors by distance to the base
       // $vectors = $vectors->sort(array(Vector::class, 'sort'));
        $wifiVectors = $wifiVectors->sort(array(Vector::class, 'sort'));
        $bluetoothvectors = $bluetoothVectors->sort(array(Vector::class, 'sort'));
        $magneticvectors = $magneticVectors->sort(array(Vector::class, 'sort'));


        // Use k=7
       // $vectors = $vectors->take(7);
        $wifiVectors = $wifiVectors->take(7);
        $bluetoothvectors = $bluetoothvectors->take(7);
        $magneticvectors = $magneticvectors->take(7);

        // Sort the k point by frequency
        $pointsFrequency = [];

        foreach([$wifiVectors, $bluetoothvectors, $magneticvectors] as $vectorss) {
            foreach ($vectorss as $vector) {
                if(!empty($vector->getVector())) {
                    $key = $vector->getPoint()->id;
                    if (array_key_exists($key, $pointsFrequency)) {
                        $pointsFrequency[$key]++;
                    } else {
                        $pointsFrequency[$key] = 1;
                    }
                }
            }
        }

        // If the point is unsure, this will keep the position at the last position
        if($oldPoint){
            $key = $oldPoint->id;
            if (array_key_exists($key, $pointsFrequency)) {
                $pointsFrequency[$key]++;
            }
        }

        arsort($pointsFrequency);

        // Send back the location found
        if(!empty($pointsFrequency)) {
            //return $pointsFrequency;
            //return $this->respond(count($vectors));
            return Point::find(key($pointsFrequency));
        }

        return null;
    }

    /**
     * @param \uKonect\Http\Requests\IPS\SaveFingerprintsRequest $request
     * @param \uKonect\Models\IPS\Floor $floor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveFingerprints(SaveFingerprintsRequest $request, Floor $floor)
    {
        $point = null;
        if(!is_null($request->input('point.id'))){
            $point = Point::find(optimus_decode($request->input('point.id')));
        }

        if(!$point) {
            $point = $floor->points()->create([
                'location' => $request->input('point.location'),
                'name'     => $request->input('point.name'),
                'x'        => $request->input('point.x'),
                'y'        => $request->input('point.y'),
            ]);
        }

        $fingerprint = $point->fingerprints()->create([]);

        if($request->has('bluetooth')){
            foreach($request->input('bluetooth') as $sample){
                $fingerprint->bluetoothSamples()->save(new BluetoothSample($sample));
            }
        }

        if($request->has('wifi')){
            foreach($request->input('wifi') as $sample){
                $fingerprint->wifiSamples()->save(new WifiSample($sample));
            }
        }

        if($request->has('magnetic')){
            $fingerprint->magneticSamples()->save(new MagneticSample($request->input('magnetic')));
        }

        return $this->respondCreated(Resource::item($point, new PointTransformer(), 'point'));
    }
}
