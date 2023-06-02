<?php

//use Illuminate\Routing\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use \App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
if (App::environment('production')) {
    URL::forceScheme('https');
}
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    return 'Not adualt';
}) -> name('not.adult');
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware("auth");
Route::get('/users', [ApiController::class, 'GetUsers'])->name('user');

