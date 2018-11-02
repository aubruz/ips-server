<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Floor extends JsonResource
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
            'blueprint' => $this->blueprint,
            'width'     => $this->width,
            'height'    => $this->height,
        ];
    }
}
