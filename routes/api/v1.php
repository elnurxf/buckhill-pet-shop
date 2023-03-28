<?php

use App\Http\Controllers\Api\v1\BrandController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\OrderStatusController;
use App\Http\Controllers\Api\v1\MainController;
use App\Http\Controllers\Api\v1\FileController;
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

Route::get('main/promotions', [MainController::class, 'promotions']);
Route::get('main/blog', [MainController::class, 'blog']);
Route::get('main/blog/{post}', [MainController::class, 'post']);

Route::get('brands', [BrandController::class, 'index']);
Route::post('brand/create', [BrandController::class, 'store']);
Route::get('brand/{brand}', [BrandController::class, 'show']);
Route::put('brand/{brand}', [BrandController::class, 'update']);
Route::delete('brand/{brand}', [BrandController::class, 'destroy']);

Route::get('categories', [CategoryController::class, 'index']);
Route::post('category/create', [CategoryController::class, 'store']);
Route::get('category/{category}', [CategoryController::class, 'show']);
Route::put('category/{category}', [CategoryController::class, 'update']);
Route::delete('category/{category}', [CategoryController::class, 'destroy']);

Route::get('order-statuses', [OrderStatusController::class, 'index']);
Route::post('order-status/create', [OrderStatusController::class, 'store']);
Route::get('order-status/{orderStatus}', [OrderStatusController::class, 'show']);
Route::put('order-status/{orderStatus}', [OrderStatusController::class, 'update']);
Route::delete('order-status/{orderStatus}', [OrderStatusController::class, 'destroy']);

Route::post('file/upload', [FileController::class, 'store']);
Route::get('file/{file}', [FileController::class, 'show']);

// Products

// Payments

// Orders

// User

// Admin