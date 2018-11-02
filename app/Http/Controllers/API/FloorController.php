<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\FloorCollection;
use Illuminate\Http\Request;
use App\Models\Building;


class FloorController extends ApiController
{
    public function index(Request $request, Building $building)
    {
        $floors = $building->floors;

        //return $this->respond(Resource::collection($floors, new FloorTransformer(), 'floors'));
        return FloorCollection::collection($floors);
    }
}
