<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoomController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $rooms = Room::query()
            ->orderBy('number')
            ->get();

        return RoomResource::collection($rooms);
    }
}
