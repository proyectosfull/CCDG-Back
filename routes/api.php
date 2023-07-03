<?php

use App\Http\Controllers\AuthController;
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

/** Auth */
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    /** Auth */
    Route::get('logout', [AuthController::class, 'logout']);

    //Cruds protegidos por permisos
    Route::group(['middleware' => ['permission']], function () {
        //Complete Apis
        // Route::apiResource('state', ApiStateController::class);
    });
});
