<?php

namespace App\Services\Reservations;

use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CreateReservationService // business logic
{
    public function execute(array $data): Reservation
    {
        return DB::transaction(function () use ($data) {
            $hasConflict = Reservation::query()
                ->where('room_id', $data['room_id'])
                ->where('status', '!=', 'cancelled')
                ->where(function ($query) use ($data) {
                    $query
                        ->where('check_in', '<', $data['check_out'])
                        ->where('check_out', '>', $data['check_in']);
                })
                ->exists();

            if ($hasConflict) {
                throw new RuntimeException(
                    'The room is not available for the selected dates.'
                );
            }

            return Reservation::create([
                'guest_id' => $data['guest_id'],
                'room_id' => $data['room_id'],
                'check_in' => $data['check_in'],
                'check_out' => $data['check_out'],
                'status' => 'confirmed',
            ]);
        });
    }
}