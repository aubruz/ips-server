<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Point extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->encoded_id,
            'name'      => $this->name,
            'location'  => $this->location,
            'x'         => $this->x,
            'y'         => $this->y,
        ];
    }
}
