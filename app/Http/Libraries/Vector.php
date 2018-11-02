<?php

namespace App\Http\Libraries;

use App\Models\Point;

/**
 * Class Vector
 * @package uKonect\Http\Libraries
 */
class Vector
{
    /**
     * @var Point $point
     */
    protected $point;

    /**
     * @var array $vector
     */
    protected $vector;

    /**
     * @var float $distance
     */
    protected $distanceToBase;

    /**
     * Vector constructor.
     *
     * @param \uKonect\Models\IPS\Point|null $point
     */
    function __construct(Point $point = null){
        $this->point = $point;
        $this->vector = [];
    }


    /**
     * @param $samples
     * @param null $baseVector
     */
    public function addWifiSamples($samples, Vector $baseVector = null){
        foreach($samples as $sample){
            $key = $sample['bssid'];
            if(!$baseVector || array_key_exists($key ,$baseVector->getVector())) {
                $this->vector[$key] = $sample['rssi'];
            }
        }
    }


    /**
     * @param $samples
     * @param null $baseVector
     */
    public function addBluetoothSamples($samples, Vector $baseVector = null){
        foreach($samples as $sample){
            $key =  sprintf("%s-%d-%d", $sample['uuid'], $sample['major'], $sample['minor']);
            if(!$baseVector || array_key_exists($key ,$baseVector->getVector())) {
                $this->vector[$key] = $sample['rssi'];
            }
        }
    }

    /**
     * @param $samples
     */
    public function addMagneticSamples($samples){
        //$this->vector['x']      = $samples['x'];
        //$this->vector['y']      = $samples['y'];
        //$this->vector['z']      = $samples['z'];
        $this->vector['north']  = $samples['north'];
        $this->vector['sky']    = $samples['sky'];
    }

    /**
     * @param \uKonect\Http\Libraries\Vector $base
     *
     * @return float|int
     */
    public function calculateEuclideanDistanceToBase(Vector $base)
    {
        // All together
        $distance = 0;
        $i = 0;
        $limit = -1;
        foreach($this->vector as $key => $value){
            $distance += pow($value - $base->getVector()[$key], 2);
            $i++;
            if( $i >= $limit && $limit != -1){
                break;
            }
        }
        $this->distanceToBase = sqrt($distance);

        return $this->distanceToBase;
    }

    public static function sort(Vector $a, Vector $b){

        $a = $a->getDistanceToBase();
        $b = $b->getDistanceToBase();

        if($a == $b){
            return 0;
        }
        else{
            return ($a < $b) ? -1 : 1;
        }
    }

    /**
     * @return bool
     */
    public function isEmpty(){
        return empty($this->vector);
    }

    /**
     * @return float
     */
    public function getDistanceToBase()
    {
        return $this->distanceToBase;
    }

    /**
     * @return Point
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * @param Point $point
     */
    public function setPoint($point)
    {
        $this->point = $point;
    }

    /**
     * @return array
     */
    public function getVector()
    {
        return $this->vector;
    }

    /**
     * @param array $vector
     */
    public function setVector($vector)
    {
        $this->vector = $vector;
    }
}
