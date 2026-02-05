<?php

use App\Http\Controllers\MockApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Mock API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('mock')->name('mock.')->group(function () {
    Route::post('/waec', [MockApiController::class, 'waec'])->name('waec');
    Route::post('/neco', [MockApiController::class, 'neco'])->name('neco');
});
