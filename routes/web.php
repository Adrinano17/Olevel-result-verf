<?php

use App\Http\Controllers\VerificationController;
use App\Http\Controllers\JambValidationController;
use App\Http\Controllers\PostUtmeController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\StudentProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('verification.index');
})->name('home');

// Home route for authenticated users (redirects after login)
Route::get('/home', function () {
    return redirect()->route('verification.index');
});

// Public routes - no login required
Route::middleware(['rate.limit.verification'])->group(function () {
    Route::prefix('verification')->name('verification.')->group(function () {
        Route::get('/', [VerificationController::class, 'index'])->name('index');
        Route::post('/verify', [VerificationController::class, 'verify'])->name('submit');
        Route::get('/result/{id}', [VerificationController::class, 'result'])->name('result');
    });
});

// JAMB Routes - public access
Route::prefix('jamb')->name('jamb.')->group(function () {
    Route::get('/', [JambValidationController::class, 'index'])->name('index');
    Route::post('/submit', [JambValidationController::class, 'submit'])->name('submit');
    Route::get('/result/{id}', [JambValidationController::class, 'result'])->name('result');
});

// Authenticated routes only
Route::middleware(['auth'])->group(function () {
    // Verification history (requires login to see history)
    Route::prefix('verification')->name('verification.')->group(function () {
        Route::get('/history', [VerificationController::class, 'history'])->name('history');
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

    // Student Profile Routes
    Route::prefix('student-profile')->name('student-profile.')->group(function () {
        Route::get('/', [StudentProfileController::class, 'index'])->name('index');
        Route::get('/create', [StudentProfileController::class, 'create'])->name('create');
        Route::post('/', [StudentProfileController::class, 'store'])->name('store');
        Route::get('/{id}', [StudentProfileController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [StudentProfileController::class, 'edit'])->name('edit');
        Route::put('/{id}', [StudentProfileController::class, 'update'])->name('update');
    });
});

// Admin Routes - requires admin authentication
Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/students', [StudentProfileController::class, 'adminIndex'])->name('students.index');
    });
});

require __DIR__.'/auth.php';
