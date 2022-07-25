<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('addWizkid', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('login-token', [AuthController::class, 'loginToken']);
Route::get('wizkids', [AuthController::class, 'users']);
Route::get('searchWizkid', [AuthController::class, 'search']);
Route::patch('updateWizkid', [AuthController::class, 'update']);
Route::delete('deleteWizkid', [AuthController::class, 'destroy']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::patch('fire', [AuthController::class, 'fire']);
    Route::patch('unFire', [AuthController::class, 'unFire']);
});
