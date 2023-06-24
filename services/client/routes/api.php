<?php

use App\Http\Controllers\Clients;
use App\Http\Controllers\Orders;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->json([
    'app' => config('app.name'),
    'time' => time(),
]));


Route::middleware('service-auth')->prefix('clients')->as('clients')->group(static function (): void {
    Route::get('/', Clients\IndexController::class)->name('list');
    Route::post('/', Clients\StoreController::class)->name('register');
    Route::put('{ulid}}')->name('update');
    Route::delete('{ulid}}')->name('delete');
    Route::prefix('{ulid}')->group(static function (): void {
        Route::get('orders', Orders\IndexController::class)->name('orders:list');
    });
});
