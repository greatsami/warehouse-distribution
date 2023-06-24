<?php

use App\Http\Controllers\Clients\IndexController;
use App\Http\Controllers\Clients\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->json([
    'app' => config('app.name'),
    'time' => time(),
]));


Route::middleware('service-auth')->prefix('clients')->as('clients')->group(static function (): void {
    Route::get('/', IndexController::class)->name('list');
    Route::post('/', StoreController::class)->name('register');
    Route::put('{ulid}}')->name('update');
    Route::delete('{ulid}}')->name('delete');
    Route::prefix('{ulid}')->group(static function (): void {
        Route::get('orders')->name('orders:list');
    });
});
