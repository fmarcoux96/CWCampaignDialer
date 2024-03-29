<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    Route::get('/campaigns', [\App\Http\Controllers\Api\DialerApiController::class, 'getCampaigns'])
        ->name('api.dialer.get-campaigns');

    Route::get('/next/{id}', [\App\Http\Controllers\Api\DialerApiController::class, 'nextCall'])
        ->name('api.dialer.next');

    Route::post('/update', [\App\Http\Controllers\Api\DialerApiController::class, 'updateCall'])
        ->name('api.dialer.update');
});
