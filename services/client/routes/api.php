<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return config('app.name');
});

Route::middleware('service-auth')->prefix('clients')->as('clients')->group(static function (): void {
    Route::get('/')->name('list');
    Route::post('/')->name('register');
    Route::put('{ulid}}')->name('update');
    Route::delete('{ulid}}')->name('delete');
    Route::prefix('{ulid}')->group(static function (): void {
        Route::get('orders')->name('orders:list');
    });
});
