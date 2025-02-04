<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/open-gate', 'GateController@openGate');
Route::post('/close-gate', 'GateController@closeGate');