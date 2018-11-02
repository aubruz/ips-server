<?php

namespace App\Http\Controllers\API;


use App\Models\Building;
use App\Http\Resources\Buildings as BuildingResource;

class BuildingController extends ApiController
{
    public function index()
    {
        $buildings = Building::all();

        //return $this->respond(Resource::collection($buildings, new BuildingTransformer(), 'buildings'));

        return BuildingResource::collection($buildings);
    }
}
