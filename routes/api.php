<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ClientAuthController;
use App\Http\Controllers\Api\ManagerAuthController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/test', function () {
    return response()->json([
        'status' => true,
        'message' => 'API Working'
    ]);
});

Route::post('/client/login', [ClientAuthController::class, 'login']);
Route::post('/manager/login', [ManagerAuthController::class, 'login']);

Route::middleware('auth:client')->group(function () {

    Route::get('/client/dashboard', [ClientAuthController::class, 'dashboard']);

    Route::post('/client/logout', [ClientAuthController::class, 'logout']);
});

Route::middleware('auth:manager')->group(function () {

    Route::get('/manager/dashboard', [ManagerAuthController::class, 'dashboard']);

    Route::post('/manager/logout', [ManagerAuthController::class, 'logout']);
});
