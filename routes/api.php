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

	