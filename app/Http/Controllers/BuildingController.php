<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use uKonect\Http\Requests;
use uKonect\Http\Controllers\Controller;
use uKonect\Models\IPS\Building;
use uKonect\Http\Requests\Admin\BuildingRequest;

class BuildingController extends Controller
{
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

        return view('admin.building.index', [
            'admin'  => $request->user('admin'),
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
        return view('admin.building.show', [
            'admin'    => $request->user('admin'),
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
        return view('admin.building.create', [
            'admin'    => $request->user('admin'),
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

        return redirect()->route('admin.buildings.show', $building->encoded_id)->withInput()
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
        return view('admin.building.show', [
            'admin'    => $request->user('admin'),
            'building' => $building,
            'readonly' => false,
        ]);
    }

    /**
     * Update building.
     *
     * @param Building $building
     * @param \uKonect\Http\Requests\Admin\GroupRequest $request
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

        return view('admin.building.show', [
            'admin'    => $request->user('admin'),
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

        return redirect()->route('admin.buildings.index')->withInput()
            ->with('status', 'Building deleted with success.')
            ->with('status_level', 'success');
    }
}
