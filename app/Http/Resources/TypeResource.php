<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use function PHPSTORM_META\type;

class TypeResource extends JsonResource
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
            'type' => 'type',
            'id' => (string) $this->getRouteKey(),
            'attributes' => [
                'name' => $this->name,
                'slug' => $this->slug,
            ],
            'links' => [
                'self' => route('api.v1.show.type', $parameters = [
                    'category' => $this->category->slug,
                    'type' => $this->getRouteKey()
                ])
            ]
        ];
    }
}
