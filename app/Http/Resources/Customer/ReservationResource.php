<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
        'id' => $this->id,
        'property' => [
            'name' => $this->property->name,
            'location' => $this->property->location,
            'status' => $this->property->status,
        ],
        'date' => $this->date,
        'time' =>$this->time,
        'status' => $this->status,
    ];
    }
}
