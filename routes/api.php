<?php

use App\Http\Controllers\ApiAccountStatusController;
use App\Http\Controllers\ApiAreaController;
use App\Http\Controllers\ApiConceptAssetController;
use App\Http\Controllers\ApiConceptExpenseByUserController;
use App\Http\Controllers\ApiCostCenterController;
use App\Http\Controllers\ApiCostCenterExpenseConceptController;
use App\Http\Controllers\ApiEmployeeController;
use App\Http\Controllers\ApiEmployeeRecordController;
use App\Http\Controllers\ApiExpenseConceptController;
use App\Http\Controllers\ApiLandPayrollController;
use App\Http\Controllers\ApiSubcostCenterController;
use App\Http\Controllers\ApiTransactionController;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\AuthController;
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
        Route::apiResource('user', ApiUserController::class);
        Route::apiResource('account-status', ApiAccountStatusController::class);
        Route::apiResource('area', ApiAreaController::class);
        Route::apiResource('concept-asset', ApiConceptAssetController::class);
        Route::apiResource('concept-expense-by-user', ApiConceptExpenseByUserController::class);
        Route::apiResource('cost-center', ApiCostCenterController::class);
        Route::apiResource('employee', ApiEmployeeController::class);
        Route::apiResource('employee-record', ApiEmployeeRecordController::class);
        Route::apiResource('expense-concept', ApiExpenseConceptController::class);
        Route::apiResource('subcost-center', ApiSubcostCenterController::class);
        Route::apiResource('transaction', ApiTransactionController::class);
        Route::apiResource('land-payroll', ApiLandPayrollController::class);
        Route::apiResource('cost-center-expense-concept', ApiCostCenterExpenseConceptController::class);
    });
});
