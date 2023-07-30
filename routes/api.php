<?php

use App\Http\Controllers\LoginController;
use App\Models\MerchSale;
use App\Models\User;
use Carbon\Carbon;
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
// Route::get('/sign-in/{sso_type}', [LoginController::class, 'sso']);
Route::post('oauth/{sso_type}', [LoginController::class, 'redirectToProvider']);

Route::post('oauth/{sso_type}', [LoginController::class, 'redirectToProvider']);

Route::get('/follower_count/{id}', function($id) {
    $followerCount = User::where('id', $id)
                        ->withCount(['followers' => function ($query) {
                            $query->whereDate('created_at', '>', Carbon::today()->subDays(30));
                        }])
                        ->get();
    
    return $followerCount[0]->followers_count;
});

Route::get('/top_sales/{id}', function($id) {
    $top_sales = MerchSale::where('user_id', $id)
    ->selectRaw('item_name, sum(quantity) as quantity')
    ->groupBy('item_name')
    ->orderBy('quantity', 'desc')
    ->limit(3)
    ->get();

    return $top_sales->toJson();
});

Route::get('/dashboard_details/{id}', function($id) {
    // $user = User::find(1)->followers;
    // $user_id = Auth::user()->id;
    // $details = User::where('id', $id)
    //                     ->with('followers')
    //                     ->with('subscribers')
    //                     ->orderBy('created_at', 'asc')
    //                     // ->paginate(2);
    //                     // ->with('followers','subscribers','donations', 'sales')
    //                     ->get();
    $details = User::where('id', $id)
                        ->with('followers', function($query){
                            $query->orderBy('created_at', 'desc');
                            // $query->limit(50);
                        })
                        ->with('subscribers', function($query){
                            $query->orderBy('created_at', 'desc');
                            // $query->limit(50);
                        })
                        ->with('donations', function($query){
                            $query->orderBy('created_at', 'desc');
                            // $query->limit(50);
                        })
                        ->with('sales', function($query){
                            $query->orderBy('created_at', 'desc');
                            // $query->limit(50);
                        })
                        ->withCount(['followers' => function ($query) {
                            $query->whereDate('created_at', '>', Carbon::today()->subDays(30));
                        }])
                        ->get();
    
    // return $details[0]->donations->toJson();

    $allItems = collect();
    $allItems = $allItems->concat($details[0]->sales);
    $allItems = $allItems->concat($details[0]->donations);
    $allItems = $allItems->concat($details[0]->followers);
    $allItems = $allItems->concat($details[0]->subscribers);
    $allItems = $allItems->concat(collect(['cc' => $details[0]->followers_count]));

    return $allItems->toJson();
    // return $details[0]->followers->merge($details[0]->donations)->sortByDesc('created_at')->toJson();
    // return $details[0]->followers->merge($details[0]->subscribers)->merge($details[0]->donations)->merge($details[0]->sales)->toJson();
    // Artisan::call(UserDataSeeder::class, false, ['user_id' => 2]);
    // $this->call(ClientSeeder::class, false, ['count' => 500]);

    // Artisan::call('db:seed', [
    //     '--class' => 'UserDataSeeder',['user_id' => 2]
    // ]);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });