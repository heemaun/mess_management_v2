<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdjustmentController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberMonthController;
use App\Http\Controllers\MonthController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

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

//resource routes
Route::resource('/adjustments', AdjustmentController::class)->except(['edit','update']);
Route::resource('/members', MemberController::class);
Route::resource('/members-months', MemberMonthController::class)->only('index')->parameters(['members-months' => 'member_month']);
Route::resource('/months', MonthController::class);
Route::resource('/notices', NoticeController::class);
Route::resource('/payments', PaymentController::class)->except(['edit','update']);
Route::resource('/users', UserController::class);
Route::resource('/settings', SettingController::class);

//login routes
Route::post('/login',[LoginController::class,'login'])->name('login');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');

//default routes
Route::get('/',[HomeController::class,'index'])->name('index');
Route::get('/home',[HomeController::class,'home'])->name('home');
Route::get('/check-login',[HomeController::class,'checkLoginHome'])->name('check-login');
Route::get('/forget-password',[HomeController::class,'getForgetPassword'])->name('get-forget-password');
Route::post('/forget-password',[HomeController::class,'forgetPassword'])->name('forget-password');
