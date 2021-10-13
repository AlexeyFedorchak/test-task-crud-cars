<?php

use App\Http\Controllers\API\AuthAPIController;
use App\Http\Controllers\API\CarBrandAPIController;
use App\Http\Controllers\API\CarModelAPIController;
use App\Http\Controllers\API\SearchCarAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthAPIController::class, 'login']);
Route::post('/registration', [AuthAPIController::class, 'registration']);
Route::middleware('auth:sanctum')->post('/logout', [AuthAPIController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/brands', [CarBrandAPIController::class, 'all']);
    Route::post('/brands', [CarBrandAPIController::class, 'create']);
    Route::get('/brands/{id}', [CarBrandAPIController::class, 'get']);
    Route::patch('/brands/{id}', [CarBrandAPIController::class, 'update']);
    Route::delete('/brands/{id}', [CarBrandAPIController::class, 'delete']);
    Route::get('/brands/{id}/models', [CarBrandAPIController::class, 'getModelsById']);
    Route::get('/brands/{id}/models/{modelId}', [CarBrandAPIController::class, 'getModelById']);

    Route::get('/models', [CarModelAPIController::class, 'all']);
    Route::get('/models/{id}', [CarModelAPIController::class, 'get']);
    Route::post('/models', [CarModelAPIController::class, 'create']);
    Route::patch('/models/{id}', [CarModelAPIController::class, 'update']);
    Route::delete('/models/{id}', [CarModelAPIController::class, 'delete']);

    Route::get('/search', [SearchCarAPIController::class, 'search']);
});
