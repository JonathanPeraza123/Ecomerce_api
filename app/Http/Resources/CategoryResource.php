<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'type' => 'category',
            'id' => (string) $this->getRouteKey(),
            'attributes' => [
                'name' => $this->name,
                'slug' => $this->slug
            ],
            'links' => [
                'self' => route('categories.show', $this->getRouteKey())
            ]
        ];
    }
}
