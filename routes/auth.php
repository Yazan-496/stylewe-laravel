<?php

use App\Http\Controllers\AuthControllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function() {

    Route::post('/signup', [AuthController::class, 'storeUser'])->name('signup');

    Route::post('/login', [AuthController::class, 'loginUser'])->name('login');

    Route::get('/user/delete/{email}', [AuthController::class, 'deleteUser']);

    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/', function (){
        return "authenticate";
    });
});
