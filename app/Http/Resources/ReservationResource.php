<?php

namespace App\Http\Resources;

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
        return [
            'id' => $this->id,

            'guest' => [
                'id' => $this->guest->id,
                'first_name' => $this->guest->first_name,
                'last_name' => $this->guest->last_name,
            ],

            'room' => [
                'id' => $this->room->id,
                'number' => $this->room->number,
                'floor' => $this->room->floor,
            ],

            'check_in' => $this->check_in?->format('Y-m-d'),
            'check_out' => $this->check_out?->format('Y-m-d'),
            'status' => $this->status,

            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
