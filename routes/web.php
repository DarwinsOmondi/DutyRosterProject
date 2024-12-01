<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DutyController;

// Authentication routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('registerForm');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('loginForm');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('duties', [DutyController::class, 'index'])->name('duties.index');


    Route::middleware(['role:manager'])->group(function () {
        Route::get('duties/create', [DutyController::class, 'create'])->name('duties.create');
        Route::post('duties', [DutyController::class, 'store'])->name('duties.store');

        Route::get('duties/{duty}/edit', [DutyController::class, 'edit'])->name('duties.edit');
        Route::put('duties/{duty}', [DutyController::class, 'update'])->name('duties.update');

        Route::delete('duties/{duty}', [DutyController::class, 'destroy'])->name('duties.destroy');
    });


    Route::middleware(['role:janitor'])->patch('duties/{duty}/mark-as-done', [DutyController::class, 'markAsDone'])->name('duties.markAsDone');
});


Route::middleware('auth')->group(function () {
    // Route for the manager to edit the duty
    Route::get('/duties/{duty}/edit', [DutyController::class, 'edit'])->name('duties.edit');

    // Route for the manager to delete the duty
    Route::delete('/duties/{duty}', [DutyController::class, 'destroy'])->name('duties.destroy');

    // Route to handle shift change requests
    Route::post('/duties/{duty}/requestShiftChange', [DutyController::class, 'requestShiftChange'])->name('duties.requestShiftChange');
});



Route::get('/', function () {
    return view('welcome');
});
