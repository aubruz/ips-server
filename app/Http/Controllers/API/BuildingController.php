<?php

namespace App\Http\Controllers\API;


use App\Models\Building;
use App\Http\Resources\BuildingCollection;

class BuildingController extends ApiController
{
    public function index()
    {
        $buildings = Building::all();

        //return $this->respond(Resource::collection($buildings, new BuildingTransformer(), 'buildings'));

        return BuildingCollection::collection($buildings);
    }
}
