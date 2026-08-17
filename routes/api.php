<?php

use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/rooms', [RoomController::class, 'index']);

Route::post('/reservations', [ReservationController::class, 'store']);

Route::get('/reservations', [ReservationController::class, 'index']);