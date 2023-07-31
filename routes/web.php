<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Models\Donation;
use App\Models\Follower;
use App\Models\MerchSale;
use App\Models\Subscriber;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\UserDataSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
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
require __DIR__.'/auth.php';

Route::get('/', function () {
    return '/';
});

// Used to seed user data for testing
Route::get('/seed/{user_id}/{table?}', function($user_id, $table) {
    UserDataSeeder::run($user_id, $table);
});

Route::get('/dashboard', [MemberController::class, 'index'])->name('dashboard'); 
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::group(['middleware' => 'guest'], function() {
    Route::get('/sign-in', [LoginController::class, 'create'])->name('login');
    
    Route::get('/sign-in/{sso_type}', [LoginController::class, 'sso']);
    Route::get('/sign-in/{sso_type}/redirect', [LoginController::class, 'ssoRedirect']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
