<?php

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


Route::get('/total_sales/{id}', function($id) {
    $donation_total = Donation::where('user_id', $id)
        ->selectRaw('sum(amount) as total_donations')
        ->whereDate('created_at', '>', Carbon::today()->subDays(30))
        ->value('total_donations');
   
    $merch_total = MerchSale::where('user_id', $id)
        ->selectRaw('sum(amount) as total_merch')
        ->whereDate('created_at', '>', Carbon::today()->subDays(30))
        ->value('total_merch');
    
    $past30days = Carbon::today()->subDays(30);
    $tierValues = Config::get('streamlabsConstants.tiers');

    $subscriptions = Subscriber::where('user_id', $id)
                                ->select('subscription_tier')
                                ->selectRaw('sum(subscription_tier) as sub_total')
                                ->whereDate('created_at', '>', $past30days)
                                ->groupBy('subscription_tier')
                                ->get();


    $subscription_totals = 0;
    foreach ($subscriptions as $tier) {
        $total =  intVal($tier['sub_total']);
        $tierNumber = $tier['subscription_tier'];
        $subscription_totals += $total * $tierValues[$tierNumber]['price'];
    }
    $totals = [
        'donations' =>number_format($donation_total, 2),
        'merch_sales' =>number_format($merch_total, 2),
        'subscriptions' => number_format($subscription_totals,2),
        'total' => number_format(round($subscription_totals + $donation_total + $merch_total, 2), 2)
    ];

    return $totals;
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
Route::get('/details/{id}', function($id) {
    // dd('id',$id);
    $details = User::where('id', $id)
                        ->with('followers', function($query){
                            // $query->orderBy('created_at', 'desc');
                            $query->limit(5);
                        })
                        ->with('subscribers', function($query){
                            // $query->orderBy('created_at', 'desc');
                            $query->limit(5);
                        })
                        ->with('donations', function($query){
                            // $query->orderBy('created_at', 'desc');
                            $query->limit(5);
                        })
                        ->with('sales', function($query){
                            // $query->orderBy('created_at', 'desc');
                            $query->limit(5);
                        })
                        ->withCount(['followers' => function ($query) {
                            $query->whereDate('created_at', '>', Carbon::today()->subDays(30));
                        }])
                        // ->with('followers','subscribers','donations', 'sales')
                        ->get();

return collect(['cc' => $details[0]->followers_count]);
$collection = collect(['product_id' => 1, 'name' => 'Desk']);
 
$collection->put('price', 100);
 
// dd($collection->all());

dd($details[0]->sales);

    $allItems = collect();
    $allItems = $allItems->concat($details[0]->sales->put('type', 'sales'));
    $allItems = $allItems->concat($details[0]->donations);
    $allItems = $allItems->concat($details[0]->followers);
    $allItems = $allItems->concat($details[0]->subscribers);

    return $allItems;

    dd($sales, $donations, $followers, $subscribers);
    $allItems = $allItems->concat();
    $allItems = $allItems->concat();
    $allItems = $allItems->concat();
    $allItems = $allItems->concat();
    return $allItems->sortBy('name');


    // $price = DB::table('orders')
    // ->where('finalized', 1)
    // ->sum('price');
    // $sales = DB::table('merch_sales')->whereDate('created_at', '>', '2023-07-17 13:01:26')->sum('amount');

    
    // return $details[0]->followers->concat($details[0]->donations)->sortBy('created_at');
    // $user = User::find(1)->followers;
    // $details = User::where('id', $id)
    // ->with('followers', function($query){
    //     $query->limit(2);
    // })
    // ->with('subscribers', function($query){
    //     $query->limit(2);
    // })
    // ->with('donations', function($query){
    //     $query->limit(2);
    // })
    // ->with('sales', function($query){
    //     $query->limit(2);
    // })
    // // ->with('followers','subscribers','donations', 'sales')
    // ->get();
    // $details = User::find($id)
    //                     ->followers()
    //                     ->subscribers()
    //                     ->paginate(2);
    //                     // ->with('followers','subscribers','donations', 'sales')
    // $subs = User::where('id', $id)
    //                     ->with('subscribers')
    //                     ->paginate(2);
                        // ->with('followers','subscribers','donations', 'sales')
    // dd($details, $subs);                    // ->get();
    // return $details;
    // Artisan::call(UserDataSeeder::class, false, ['user_id' => 2]);
    // $this->call(ClientSeeder::class, false, ['count' => 500]);

    // Artisan::call('db:seed', [
    //     '--class' => 'UserDataSeeder',['user_id' => 2]
    // ]);
});


Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/seed/{user_id}/{table?}', function($user_id, $table) {
    // Artisan::call(UserDataSeeder::class, false, ['user_id' => 2]);
    UserDataSeeder::run($user_id, $table);
    // $this->call(ClientSeeder::class, false, ['count' => 500]);

    // Artisan::call('db:seed', [
    //     '--class' => 'UserDataSeeder',['user_id' => 2]
    // ]);
});
Route::group(['middleware' => 'guest'], function() {
    Route::get('/a', function() {
        $user = User::where('id',1)->followers()->first();
        dd($user);
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
