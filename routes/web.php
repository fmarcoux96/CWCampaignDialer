<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/campaigns', [\App\Http\Controllers\CampaignsController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/sample-file', [\App\Http\Controllers\CampaignsController::class, 'downloadSample'])->name('campaigns.download-sample');
    Route::get('/campaigns/{campaign}', [\App\Http\Controllers\CampaignsController::class, 'show'])->name('campaigns.show');

    Route::get('/users', [\App\Http\Controllers\UsersController::class, 'index'])->name('users.index');

    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
});
