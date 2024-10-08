<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DeviceController;

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

Route::post('/register-device',[DeviceController::class,'register']);
Route::post('/send-device-data',[DeviceController::class,'device_data']);
Route::post('/get-notices',[DeviceController::class,'get_notices']);
Route::post('/get-languages',[DeviceController::class,'languages']);
Route::post('/get-notice-name',[DeviceController::class,'get_notice_tittle']);
Route::post('/get-all-notices',[DeviceController::class,'get_all_notices']);
Route::post('/get-all-notices-for-db',[DeviceController::class,'get_notices_for_db']);
Route::post('/upload-roomdb-data-to-server',[DeviceController::class,'insert_roomdb_data']);
Route::post('/save-non-idle-device-data',[DeviceController::class,'save_non_idle_device_state']);
Route::post('/get-branch-based-notices',[DeviceController::class,'get_branch_based_notices']);
Route::post('/get-branch-based-notices2',[DeviceController::class,'get_branch_based_notices_offline']);
Route::post('/get-branch-based-notices-with-disclaimer',[DeviceController::class,'get_branch_based_notices_offline_with_disclaimer']);
Route::post('/get-branch-based-notices-with-disclaimer-updates',[DeviceController::class,'get_branch_based_notices_offline_with_disclaimer_new']);



	