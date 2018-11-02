<?php

namespace App\Http\Controllers\API;


use App\Models\Building;
use App\Http\Resources\Building as BuildingResource;

class BuildingController extends ApiController
{
    public function index()
    {
        $buildings = Building::all();

        return BuildingResource::collection($buildings);
    }
}
