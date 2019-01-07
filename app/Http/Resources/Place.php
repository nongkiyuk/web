<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Image as ImageResource;

class Place extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'address' => $this->address,
            'cover' => new ImageResource($this->getCover()),
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'images' => ImageResource::collection($this->images)
        ];
    }
}
