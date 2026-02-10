<?php

use App\Http\Controllers\VerificationController;
use App\Http\Controllers\JambValidationController;
use App\Http\Controllers\PostUtmeController;
use App\Http\Controllers\AdmissionController;
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

Route::middleware(['auth'])->group(function () {
    // JAMB Routes
    Route::prefix('jamb')->name('jamb.')->group(function () {
        Route::get('/', [JambValidationController::class, 'index'])->name('index');
        Route::post('/submit', [JambValidationController::class, 'submit'])->name('submit');
        Route::get('/result/{id}', [JambValidationController::class, 'result'])->name('result');
    });

    // Post-UTME Routes
    Route::prefix('post-utme')->name('postutme.')->group(function () {
        Route::get('/', [PostUtmeController::class, 'index'])->name('index');
        Route::post('/submit', [PostUtmeController::class, 'submit'])->name('submit');
        Route::get('/result/{id}', [PostUtmeController::class, 'result'])->name('result');
    });

    // Admission Validation Routes
    Route::prefix('admission')->name('admission.')->group(function () {
        Route::get('/', [AdmissionController::class, 'index'])->name('index');
        Route::post('/validate', [AdmissionController::class, 'store'])->name('validate');
        Route::get('/result/{id}', [AdmissionController::class, 'result'])->name('result');
        Route::get('/history', [AdmissionController::class, 'history'])->name('history');
    });
});

require __DIR__.'/auth.php';
