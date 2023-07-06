<?php

use App\Http\Controllers\ApiCatalogController;
use App\Http\Controllers\ApiExpenseController;
use App\Http\Controllers\ApiSubCatalogController;
use App\Http\Controllers\ApiUserController;
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
        Route::apiResource('catalog', ApiCatalogController::class);
        Route::apiResource('subcatalog', ApiSubCatalogController::class);
        Route::apiResource('user', ApiUserController::class);
        Route::apiResource('expense', ApiExpenseController::class);
    });
});
