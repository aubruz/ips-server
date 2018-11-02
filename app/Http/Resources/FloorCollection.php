<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FloorCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($floor)
    {
        return [
            'id'        => $floor->encoded_id,
            'name'      => $floor->name,
            'blueprint' => $floor->blueprint,
            'width'     => $floor->width,
            'height'    => $floor->height,
        ];
    }
}
