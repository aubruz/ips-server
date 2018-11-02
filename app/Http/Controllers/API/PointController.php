<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Point as PointResource;
use Illuminate\Http\Request;
use App\Models\Floor;
use App\Models\Point;

class PointController extends ApiController
{
    public function index(Request $request, Floor $floor)
    {
        $points = $floor->points;

        return PointResource::collection($points);
    }

    public function destroy(Request $request, Floor $floor, Point $point)
    {
        //TODO verify that the point belongs to the $floor
        $point->delete();

        $this->respondDeleted();
    }
}
