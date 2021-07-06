<?php

namespace App\Http\Resources;

use Attribute;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'type' => 'brand',
            'id' => (string) $this->getRouteKey(),
            'attributes' => [
                'name' => $this->name,
                'slug' => $this->slug
            ],
            'links' => [
                'self' => route('brands.show', $this->getRouteKey())
            ]
        ];
    }
}
