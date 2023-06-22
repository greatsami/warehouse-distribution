<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', static fn () => response()->json()([
    'app' => config('app.name'),
    'time' => time(),
]));

Route::post('login', LoginController::class)->name('auth:login');

Route::post('register', RegisterController::class)->name('auth:register');
