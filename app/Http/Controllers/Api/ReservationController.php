<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Services\Reservations\CreateReservationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReservationController extends Controller // Request validation
{
    public function store(StoreReservationRequest $request, CreateReservationService $service): JsonResponse {
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

    public function index(): AnonymousResourceCollection
    {
        $reservations = Reservation::query()
            ->with([
                'guest',
                'room',
            ])
            ->orderBy('check_in')
            ->get();

        return ReservationResource::collection($reservations);
    }
}