<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PointCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($point)
    {
        return [
            'id'        => $point->encoded_id,
            'name'      => $point->name,
            'location'  => $point->location,
            'x'         => $point->x,
            'y'         => $point->y,
        ];
    }
}
