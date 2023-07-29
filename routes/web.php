<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Models\User;
use Database\Seeders\UserDataSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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
    Route::get('/a', function() {
        $user = User::where('id',1)->followers()->first();
        dd($user);
    });

    Route::get('/seed', function() {
        // Artisan::call(UserDataSeeder::class, false, ['user_id' => 2]);
        UserDataSeeder::run(1);
        // $this->call(ClientSeeder::class, false, ['count' => 500]);

        // Artisan::call('db:seed', [
        //     '--class' => 'UserDataSeeder',['user_id' => 2]
        // ]);
    });

    Route::get('/sign-in', [LoginController::class, 'create'])->name('login');
    
    Route::get('/sign-in/{sso_type}', [LoginController::class, 'sso']);
    Route::get('/sign-in/{sso_type}/redirect', [LoginController::class, 'ssoRedirect']);
});

// Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', [MemberController::class, 'index'])->name('dashboard'); 
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
