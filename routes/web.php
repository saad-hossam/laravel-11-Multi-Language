<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\WelcomeController;
use App\Http\Controllers\Dashboard\Auth\AuthController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localize',
        'localizationRedirect',
        'localeSessionRedirect',
    ]
], function () {
    Route::get('/test', function () {
        return view('dashboard.welcome');
    });
    ////////////////////////////// Auth///////////////////////////////////////
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class,'login'])->name('login.post');
    Route::post('logout', [AuthController::class,'logout'])->name('logout');
    ////////////////////////////// Auth End///////////////////////////////////////


    ////////////////////////////// Welcome Routes///////////////////////////////////////
    Route::group(['middleware'=>'auth:admin'],function(){
        Route::get('welcome', [WelcomeController::class,'index'])->name('dashboard.index');
    });
});
