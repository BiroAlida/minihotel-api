<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $rooms = Room::query()
            ->orderBy('number')
            ->get();

        return RoomResource::collection($rooms);
    }

    /*
        When this type of request arrives: GET /api/rooms/available?check_in=2026-08-20&check_out=2026-08-24
        validate the request so that only the available rooms will appear in the Reservation form  
    */
    public function available(Request $request)
    {
        $validated = $request->validate([
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
        ]);

        $rooms = Room::query()
            ->whereDoesntHave('reservations', function ($query) use ($validated) { //only search for rooms, that doesnt have a reservation for the given date
                $query
                    ->where('check_in', '<', $validated['check_out'])
                    ->where('check_out', '>', $validated['check_in']);
            })
            ->orderBy('number')
            ->get();

        return RoomResource::collection($rooms);
    }
}
