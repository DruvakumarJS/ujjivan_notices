<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\HomeController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('devices',[DevicesController::class,'index'])->name('devices');
Route::get('add-device',[DevicesController::class,'create'])->name('add_device');
Route::post('save-device',[DevicesController::class,'store'])->name('save_device');
Route::get('view_device_datails/{id}',[DevicesController::class,'show'])->name('view_device_datails');
Route::get('edit_device_datails/{id}',[DevicesController::class,'edit'])->name('edit_device_datails');
Route::put('update_device_datails/{id}',[DevicesController::class,'update'])->name('update_device_datails');
Route::get('delete_device_datails/{id}',[DevicesController::class,'destroy'])->name('delete_device_datails');
Route::post('search_device',[DevicesController::class,'search'])->name('search_device');

Route::get('notices',[NoticeController::class,'index'])->name('notices');

Route::get('select_template',[NoticeController::class,'selct_template'])->name('choose_template');
Route::get('set_template',[NoticeController::class,'set_template'])->name('set_template');

Route::get('create_notice',[NoticeController::class,'create'])->name('create_notice');
Route::post('save-notice',[NoticeController::class,'store'])->name('save_notice');
Route::get('view-notice-datails/{id}',[NoticeController::class,'show'])->name('view_notice_datails');
Route::get('edit-notice-datails/{id}',[NoticeController::class,'edit'])->name('edit_notice_datails');
Route::put('update-notice-datails/{id}',[NoticeController::class,'update'])->name('update_notice_datails');
//Route::post('update-notice',[NoticeController::class,'store'])->name('update_notice');

Route::get('delete-notice-datails/{id}',[NoticeController::class,'destroy'])->name('delete_notice_datails');
Route::post('search-notice',[NoticeController::class,'search'])->name('search_notice');

Route::get('templates',[NoticeController::class,'templates'])->name('templates');

Route::post('ck_upload',[NoticeController::class,'ck_upload'])->name('ck_upload');
Route::post('filter_notice',[NoticeController::class,'filter'])->name('filter_notice');

Route::post('save-rbi-notice',[NoticeController::class,'store_rbi_notice'])->name('save_rbi_notice');




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



