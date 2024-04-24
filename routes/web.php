<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuditController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('ujjivan_notices/{lang}',[NoticeController::class,'AllNotices'])->name('ujjivan_notices');
Route::get('search_notice/{lang}/{id}',[NoticeController::class,'search_public_notice'])->name('search_public_notice');


Route::group(['middleware' => 'auth'], function () {
    // Your protected routes go here

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('devices',[DevicesController::class,'index'])->name('devices');
Route::get('add-device',[DevicesController::class,'create'])->name('add_device');
Route::post('save-device',[DevicesController::class,'store'])->name('save_device');
Route::get('view_device_datails/{id}',[DevicesController::class,'show'])->name('view_device_datails');
Route::get('edit_device_datails/{id}',[DevicesController::class,'edit'])->name('edit_device_datails');
Route::put('update_device_datails/{id}',[DevicesController::class,'update'])->name('update_device_datails');
Route::get('delete_device_datails/{id}',[DevicesController::class,'destroy'])->name('delete_device_datails');
Route::post('search_device',[DevicesController::class,'search'])->name('search_device');


Route::get('analytics/{id}',[DevicesController::class,'analytics'])->name('analytics');
Route::post('get_device_health_data',[DevicesController::class,'get_device_health_data'])->name('get_device_health_data');
Route::post('fetch_analytics_data',[DevicesController::class,'fetch_analytics_data'])->name('fetch_analytics_data');


Route::get('notices/{lang}',[NoticeController::class,'index'])->name('notices');
Route::get('select_template/{lang}',[NoticeController::class,'selct_template'])->name('choose_template');
Route::get('set_template',[NoticeController::class,'set_template'])->name('set_template');

Route::get('select_language/{lang}/{id}',[NoticeController::class,'select_language'])->name('select_language');
Route::post('add_notices',[NoticeController::class,'add_notices'])->name('add_notices');
Route::post('add_rbi_notice',[NoticeController::class,'add_rbi_notice'])->name('add_rbi_notice');


Route::get('create_notice',[NoticeController::class,'create'])->name('create_notice');
Route::post('save-notice',[NoticeController::class,'store'])->name('save_notice');
Route::get('view-notice-datails/{id}',[NoticeController::class,'show'])->name('view_notice_datails');
Route::get('edit-notice-datails/{id}',[NoticeController::class,'edit'])->name('edit_notice_datails');
Route::put('update-notice-datails/{id}',[NoticeController::class,'update'])->name('update_notice_datails');

Route::get('edit-notices-datail/{id}/{lang}',[NoticeController::class,'edit_multilingual'])->name('edit_multi_notice_datails');
Route::put('update-multilang-notice-datails',[NoticeController::class,'update_multilang_notice'])->name('update_multilang_notice');


//Route::post('update-notice',[NoticeController::class,'store'])->name('update_notice');

Route::get('delete-notice-datails/{id}',[NoticeController::class,'destroy'])->name('delete_notice_datails');
Route::get('search-notice',[NoticeController::class,'search'])->name('search_notice');

Route::get('templates',[NoticeController::class,'templates'])->name('templates');

Route::post('ck_upload',[NoticeController::class,'ck_upload'])->name('ck_upload');
//Route::get('filter_notice/{lang}',[NoticeController::class,'filter'])->name('filter_notice');

Route::post('save-rbi-notice',[NoticeController::class,'store_rbi_notice'])->name('save_rbi_notice');
Route::get('edit-rbi-notice/{id}',[NoticeController::class,'edit_rbi_notice'])->name('edit_rbi_notice');
Route::put('update-rbi_notice-datails/{id}',[NoticeController::class,'update_rbi_notice'])->name('update_rbi_notice_datails');

Route::get('edit-rbi-notice-datails/{id}/{lang}',[NoticeController::class,'edit_multi_rbi_notice'])->name('edit_multi_rbi_notice_datails');
Route::put('update-multi-rbi_notice-datails',[NoticeController::class,'update_multi_rbi_notice'])->name('update_multi_rbi_notice_datails');

Route::get('modify-status/{id}',[NoticeController::class,'modify_status'])->name('modify_notice_status');
Route::get('modify-all-status/{id}/{status}',[NoticeController::class,'modify_all_status'])->name('modify_all_notice_status');
Route::get('delete-all/{id}',[NoticeController::class,'delete_all'])->name('delete_all_notice_datails');
Route::get('view-notices/{id}',[NoticeController::class,'view_notices'])->name('view_notices');




Route::get('settings',[HomeController::class,'settings'])->name('settings');
Route::get('regions',[HomeController::class,'region'])->name('regions');
Route::post('save-region',[HomeController::class,'save_region'])->name('save_region');
Route::put('update-region',[HomeController::class,'update_region'])->name('update_region');
Route::get('delete-region/{id}',[HomeController::class,'delete_region'])->name('delete_region');

Route::get('branches',[HomeController::class,'branches'])->name('branches');
Route::post('save-branch',[HomeController::class,'save_branch'])->name('save_branch');
Route::put('update-branch',[HomeController::class,'update_branch'])->name('update_branch');
Route::get('delete-branch/{id}',[HomeController::class,'delete_branch'])->name('delete_branch');


Route::get('banks',[HomeController::class,'banks'])->name('banks');
Route::post('save-bank',[HomeController::class,'save_bank'])->name('save_bank');
Route::put('update-bank',[HomeController::class,'update_bank'])->name('update_bank');
Route::get('delete-bank/{id}',[HomeController::class,'delete_bank'])->name('delete_bank');


Route::get('get_bank_details',[HomeController::class,'get_bank_details'])->name('get_bank_details');

Route::get('/qrcode', [HomeController::class, 'showqrcode'])->name('qrcode');
Route::post('/authenticate', [HomeController::class, 'authenticate'])->name('authenticate');


Route::get('audit',[AuditController::class,'index'])->name('audit');
Route::get('search_audit',[AuditController::class,'search_audit'])->name('search_audit');

});




