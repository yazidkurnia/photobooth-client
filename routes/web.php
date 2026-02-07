<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoBoothController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/photobooth', [PhotoBoothController::class, 'index']);
