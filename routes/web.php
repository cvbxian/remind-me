<?php

use App\Http\Controllers\Admin\UserActivityController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    return redirect()->route(auth()->user()->isAdmin() ? 'admin.users.index' : 'activities.index');
});

// Release record: shows which build is running (no secrets).
Route::get('/version', fn () => response()->json([
    'version' => config('release.version'),
    'commit'  => config('release.commit'),
]));

// Guests only
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Signed-in users only
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('activities', ActivityController::class)->except('show');
    Route::patch('/activities/{activity}/done', [ActivityController::class, 'toggleDone'])
        ->name('activities.done');

    Route::get('/requests', [ServiceRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [ServiceRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [ServiceRequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{serviceRequest}', [ServiceRequestController::class, 'show'])->name('requests.show');
    Route::patch('/requests/{serviceRequest}/status', [ServiceRequestController::class, 'updateStatus'])
        ->name('requests.updateStatus');
});

// Administrator only: see every user and manage their activities.
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

    Route::get('/users/{user}/activities/create', [UserActivityController::class, 'create'])
        ->name('users.activities.create');
    Route::post('/users/{user}/activities', [UserActivityController::class, 'store'])
        ->name('users.activities.store');

    Route::get('/activities/{activity}/edit', [UserActivityController::class, 'edit'])
        ->name('activities.edit');
    Route::put('/activities/{activity}', [UserActivityController::class, 'update'])
        ->name('activities.update');
    Route::delete('/activities/{activity}', [UserActivityController::class, 'destroy'])
        ->name('activities.destroy');
    Route::patch('/activities/{activity}/done', [UserActivityController::class, 'toggleDone'])
        ->name('activities.done');
});