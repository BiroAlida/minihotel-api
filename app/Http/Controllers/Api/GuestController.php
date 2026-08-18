<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GuestResource;
use App\Models\Guest;

class GuestController extends Controller
{
    public function index()
    {
        $guests = Guest::query()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return GuestResource::collection($guests);
    }
}
