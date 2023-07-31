<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/top_sales/{id}', [DashboardController::class, 'getTopSales']);

Route::get('/recent_activity/{id}/{offset}/{limit}', [DashboardController::class, 'getRecentActivity']);

Route::get('/follower_count/{id}', [DashboardController::class, 'getFollowerCount']);

Route::get('/total_sales/{id}', [DashboardController::class, 'getTotalSales']);


Route::get('/sign-in/{sso_type}', [LoginController::class, 'sso']);
Route::post('oauth/{sso_type}', [LoginController::class, 'redirectToProvider']);

Route::post('oauth/{sso_type}', [LoginController::class, 'redirectToProvider']);


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });