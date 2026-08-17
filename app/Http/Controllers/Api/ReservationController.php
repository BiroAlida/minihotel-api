<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Services\Reservations\CreateReservationService;
use Illuminate\Http\JsonResponse;

class ReservationController extends Controller // Request validation
{
    public function store(
        StoreReservationRequest $request,
        CreateReservationService $service
    ): JsonResponse {
        $reservation = $service->execute(
            $request->validated()
        );

        $reservation->load([
            'guest',
            'room',
        ]);

        return (new ReservationResource($reservation))
            ->response()
            ->setStatusCode(201);
    }
}