<?php

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

Route::get('/', function () {
    return response()->noContent();
});

Route::prefix('v1')
    ->namespace('v1')
    ->name('v1.')
    ->middleware('throttle:60,1')
    ->group(function () {
        require __DIR__ . '/api/v1.php';
    });
