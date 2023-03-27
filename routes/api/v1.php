<?php

use App\Http\Controllers\Api\v1\BrandController;
// use App\Http\Controllers\Api\v1\AuthController;
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
    return response([
        'version' => 1,
        'name'    => 'Buckhill Pet Shop API',
    ], 200);
});

// Route::post('login', [AuthController::class, 'login']);
// Route::post('register', [AuthController::class, 'register']);
// Route::post('password/otp', [AuthController::class, 'password_otp']);
// Route::post('password/reset', [AuthController::class, 'password_reset']);

Route::get('brands', [BrandController::class, 'index']);
Route::post('brand/create', [BrandController::class, 'store']);
Route::get('brand/{brand}', [BrandController::class, 'show']);
Route::put('brand/{brand}', [BrandController::class, 'update']);
Route::delete('brand/{brand}', [BrandController::class, 'destroy']);
