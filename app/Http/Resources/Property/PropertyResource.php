<?php

namespace App\Http\Resources\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'Property' => [
                'name'        =>$this->name,
                'type_name'   => $this->type ? $this->type->name : null,
                'area'        =>$this->area,
                'rooms'       =>$this->rooms,
                'location'    =>$this->location,
                'price'       =>$this->price,
                'description' =>$this->description,
                'status'      =>$this->status
            ]
        ];
    }
}

//'name', 'location', 'rooms', 'area', 'price', 'description', 'status', 'type_id'
