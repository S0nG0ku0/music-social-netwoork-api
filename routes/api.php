<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;

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

Route::post('register', [API\AuthController::class, 'register']);
Route::post('login', [API\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('users/{id}', [API\UserController::class, 'show']);
    Route::put('users/{id}', [API\UserController::class, 'update']);
    Route::post('logout', [AuthController::class, 'logout']);
});
