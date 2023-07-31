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

Route::post('/top_sales', [DashboardController::class, 'getTopSales']);
Route::post('/follower_count', [DashboardController::class, 'getFollowerCount']);
Route::post('/total_sales', [DashboardController::class, 'getTotalSales']);

Route::post('/recent_activity', [DashboardController::class, 'getRecentActivity']);




Route::get('/sign-in/{sso_type}', [LoginController::class, 'sso']);
Route::post('oauth/{sso_type}', [LoginController::class, 'redirectToProvider']);

Route::post('oauth/{sso_type}', [LoginController::class, 'redirectToProvider']);


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });