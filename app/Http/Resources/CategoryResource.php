<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'parent'=>$this->parent,
            'created_from' =>$this->created_at->diffForHumans(),
            'child'=>CategoryCollection::make($this->whenloaded('child')),//رجعلي ال children  على شكل collection
            'products'=>ProductResource::collection($this->whenloaded('products')),
        ];
    }
}
