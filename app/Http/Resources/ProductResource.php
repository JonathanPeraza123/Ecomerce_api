<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'type' => 'product',
            'id' => (string) $this->resource->getRouteKey(),
            'attributes' => [
                'name' => $this->name,
                'slug' => $this->slug,
                'price' => $this->price,
                'quantify' => $this->quantity,
                'description' => $this->description,
                'in_stock' => $this->in_stock,
            ],
            'links' => [
                'self' => route('p.show', $this->getRouteKey())
            ]
        ];
    }
}
