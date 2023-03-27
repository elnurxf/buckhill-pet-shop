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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/', function () {
    return response()->noContent();
});


Route::prefix('v1')->namespace('v1')->name('v1.')->group(function () {

    Route::get('/', function () {
        return response([
            'version'   => 1,
            'name' => 'Buckhill Pet Shop API',
        ], 200);
    });
});