<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => 'guest'], function() {
    Route::get('/sign-in', [LoginController::class, 'create'])->name('login');
    
    Route::get('/sign-in/{sso_type}', [LoginController::class, 'sso']);
    Route::get('/sign-in/{sso_type}/redirect', [LoginController::class, 'ssoRedirect']);
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', [MemberController::class, 'index'])->name('dashboard'); 
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
