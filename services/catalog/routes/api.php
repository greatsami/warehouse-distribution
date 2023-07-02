<?php

use App\Http\Controllers\Products\IndexController;
use App\Http\Controllers\Products\ShowController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->json([
    'app' => config('app.name'),
    'time' => time(),
]));


Route::middleware('service-auth')->prefix('products')->as('products')->group(static function (): void {
    Route::get('/', IndexController::class)->name('index');
    Route::get('{ulid}', ShowController::class)->name('show');
});
