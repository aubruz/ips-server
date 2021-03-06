<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Building;
use App\Models\Floor;
use App\Http\Requests\FloorRequest;

class FloorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Index floors of given building.
     *
     * @param \Illuminate\Http\Request $request
     * @param Building $building
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request, Building $building)
    {
        $search = $request->input('search');

        if ($search === null) {
            $floors = Floor::where('building_id', $building->id)->paginate(20);
        } else {
            $floors = Floor::where('building_id', $building->id)->where('name', 'like', '%'.$search.'%')
                ->paginate(20);
        }

        return view('floor.index', [
            'admin'     => $request->user(),
            'building'  => $building,
            'floors'    => $floors,
            'search'    => $search,
        ]);
    }

    /**
     * Show floor of given building.
     *
     * @param Building $building
     * @param Floor $floor
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Building $building, Floor $floor, Request $request)
    {
        return view('floor.show', [
            'admin'    => $request->user(),
            'building' => $building,
            'floor'    => $floor,
            'readonly' => true,
        ]);
    }

    /**
     * Create floor of given building.
     *
     * @param Building $building
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Building $building, Request $request)
    {
        return view('floor.create', [
            'admin'    => $request->user(),
            'building' => $building,
            'readonly' => true,
        ]);
    }

    /**
     * Store floor for givenbuilding.
     *
     * @param Building $building
     * @param FloorRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @internal param $
     */
    public function store(Building $building, FloorRequest $request)
    {
        $floor = new Floor();
        $floor->name = $request->input('name');

        $building->floors()->save($floor);

        return redirect()->route('buildings.floors.show', [$building->encoded_id, $floor->encoded_id])->withInput()
            ->with('status', 'Floor created with success.')
            ->with('status_level', 'success');
    }

    /**
     * Edit floor of given building.
     *
     * @param Building $building
     * @param Floor $floor
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Building $building, Floor $floor, Request $request)
    {
        return view('floor.show', [
            'admin'    => $request->user(),
            'building' => $building,
            'floor' => $floor,
            'readonly' => false,
        ]);
    }

    /**
     * Update floor of given building.
     *
     * @param Building $building
     * @param Floor $floor
     * @param \App\Http\Requests\FloorRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @internal param $
     */
    public function update(Building $building, Floor $floor, FloorRequest $request)
    {
        $floor->name = $request->input('name', $floor->name);
        $floor->width = $request->input('width', $floor->width);
        $floor->height = $request->input('height', $floor->height);

        if ($request->hasFile('blueprint')) {
            $name = sprintf('blueprints/%s', $floor->encoded_id);
            $file = file_get_contents($request->file('blueprint')->getRealPath());
            Storage::cloud()->put($name, $file, 'public');
            //TODO change to local storage
            $url = sprintf('https://%s.s3.amazonaws.com/%s', config('filesystems.disks.s3.bucket'), $name);
            $floor->blueprint = $url;
        }

        $floor->save();

        return view('floor.show', [
            'admin'    => $request->user(),
            'building' => $building,
            'floor'    => $floor,
            'readonly' => true,
        ]);
    }

    /**
     * Destroy floor of given building.
     *
     * @param Building $building
     * @param Floor $floor
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Building $building, Floor $floor)
    {
        $floor->delete();

        return redirect()->route('buildings.floors.index', $building->encoded_id)->withInput()
            ->with('status', 'Floor deleted with success.')
            ->with('status_level', 'success');
    }
}
