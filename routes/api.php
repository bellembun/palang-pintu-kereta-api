<?php

use App\Http\Controllers\GateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/open-gate', [GateController::class, 'openGate']);
Route::post('/close-gate', [GateController::class, 'closeGate']);