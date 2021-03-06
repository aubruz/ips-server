<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;
use App\Http\Requests\BuildingRequest;

class BuildingController extends Controller
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
     * Index groups.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search === null) {
            $buildings = Building::paginate(20);
        } else {
            $buildings = Building::where('name', 'like', '%'.$search.'%')
                ->paginate(20);
        }

        return view('building.index', [
            'admin'  => $request->user(),
            'buildings' => $buildings,
            'search' => $search,
        ]);
    }

    /**
     * Show building.
     *
     * @param Building $building
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Building $building, Request $request)
    {
        return view('building.show', [
            'admin'    => $request->user(),
            'building' => $building,
            'readonly' => true,
        ]);
    }

    /**
     * Create building.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        return view('building.create', [
            'admin'    => $request->user(),
            'readonly' => true,
        ]);
    }

    /**
     * Store building.
     *
     * @param BuildingRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @internal param $
     */
    public function store(BuildingRequest $request)
    {
        $building = new Building();
        $building->name = $request->input('name');
        $building->address = $request->input('address');
        $building->save();

        return redirect()->route('buildings.show', $building->encoded_id)->withInput()
            ->with('status', 'Building created with success.')
            ->with('status_level', 'success');
    }

    /**
     * Edit building.
     *
     * @param Building $building
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Building $building, Request $request)
    {
        return view('building.show', [
            'admin'    => $request->user(),
            'building' => $building,
            'readonly' => false,
        ]);
    }

    /**
     * Update building.
     *
     * @param Building $building
     * @param \App\Http\Requests\BuildingRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @internal param $
     */
    public function update(Building $building, BuildingRequest $request)
    {
        $building->name = $request->input('name', $building->name);
        $building->address = $request->input('address', $building->address);

        /*if ($request->hasFile('map')) {
            $name = sprintf('logos/%s', $building->encoded_id);
            $file = file_get_contents($request->file('logo')->getRealPath());
            Storage::cloud()->put($name, $file, 'public');

            $url = sprintf('https://%s.s3.amazonaws.com/%s', config('filesystems.disks.s3.bucket'), $name);
            $building->map = $url;
        }*/

        $building->save();

        return view('building.show', [
            'admin'    => $request->user(),
            'building' => $building,
            'readonly' => true,
        ]);
    }

    /**
     * Destroy building.
     *
     * @param Building $building
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Building $building)
    {
        $building->delete();

        return redirect()->route('buildings.index')->withInput()
            ->with('status', 'Building deleted with success.')
            ->with('status_level', 'success');
    }
}
