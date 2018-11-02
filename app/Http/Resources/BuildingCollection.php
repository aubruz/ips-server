<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BuildingCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($building)
    {
        return [
            'id'        => $building->encoded_id,
            'name'      => $building->name,
            'address'   => $building->address,
        ];
    }
}
