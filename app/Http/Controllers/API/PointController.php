<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Transformers\API\PointTransformer;
use App\Http\Transformers\Resource;
use App\Models\Floor;
use App\Models\Point;

class PointController extends ApiController
{
    public function index(Request $request, Floor $floor)
    {
        $points = $floor->points;

        return $this->respond(Resource::collection($points, new PointTransformer(), 'points'));
    }

    public function destroy(Request $request, Floor $floor, Point $point)
    {
        $point->delete();
    }
}
