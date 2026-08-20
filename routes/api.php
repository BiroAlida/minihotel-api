<?php

use App\Http\Controllers\Api\GuestController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/rooms', [RoomController::class, 'index']); //GET endpoint for http://127.0.0.1:8000/api/rooms

Route::get('/rooms/available', [RoomController::class, 'available']); //GET /api/rooms/available

Route::post('/reservations', [ReservationController::class, 'store']); //POST /api/reservations

Route::get('/reservations', [ReservationController::class, 'index']); //GET /api/reservations

Route::get('/guests', [GuestController::class, 'index']); //GET /api/guests
