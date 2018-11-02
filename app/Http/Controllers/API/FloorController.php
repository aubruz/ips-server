<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Floor as FloorResource;
use Illuminate\Http\Request;
use App\Models\Building;


class FloorController extends ApiController
{
    public function index(Request $request, Building $building)
    {
        $floors = $building->floors;

        return FloorResource::collection($floors);
    }
}
