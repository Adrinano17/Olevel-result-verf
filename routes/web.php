<?php

use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('verification.index');
    }
    return redirect()->route('login');
})->name('home');

// Home route for authenticated users (redirects after login)
Route::get('/home', function () {
    return redirect()->route('verification.index');
})->middleware('auth');

Route::middleware(['auth', 'rate.limit.verification'])->group(function () {
    Route::prefix('verification')->name('verification.')->group(function () {
        Route::get('/', [VerificationController::class, 'index'])->name('index');
        Route::post('/verify', [VerificationController::class, 'verify'])->name('submit');
        Route::get('/result/{id}', [VerificationController::class, 'result'])->name('result');
        Route::get('/history', [VerificationController::class, 'history'])->name('history');
    });
});

require __DIR__.'/auth.php';
