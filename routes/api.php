<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\NewsController;

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

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:api', 'role'])->group(function () {

        Route::middleware(['scope:admin'])->group(function () {
            Route::apiResource('news', NewsController::class);
        });
        Route::post('news/{uuid}/comment', 'CommentController@store');
    });
});
