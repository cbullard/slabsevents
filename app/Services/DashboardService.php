<?php
namespace App\Services;

use App\Models\Donation;
use App\Models\Follower;
use App\Models\MerchSale;
use App\Models\Subscriber;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class DashboardService {

  private function validateErrors($request) {
    $validatedRequest = Validator::make($request->all(), [
      'id' => 'integer|required'
    ]);
    
    $validation_errors = $validatedRequest->errors();
    if ($validation_errors->any()) {
      $data = [
        "status" => "404",
        "message" => $validation_errors
      ];
    
      return response()->json($data);
    }
  }

  public function getTopSales($request)
  {
    $validation_errors = $this->validateErrors($request);
    if($validation_errors){
      return $this->validateErrors($request);
    }

    $top_sales = MerchSale::where('user_id', $request->id)
    ->selectRaw('item_name, sum(quantity) as quantity')
    ->groupBy('item_name')
    ->orderBy('quantity', 'desc')
    ->limit(3)
    ->get();

    return $top_sales->toJson();
  }

  public function getRecentActivity($request)
  {
    $validation_errors = $this->validateErrors($request);
    if($validation_errors){
      return $this->validateErrors($request);
    }

    $offset = $request->offset;
    $limit = $request->limit;

    $activity = User::where('id', $request->id)
                    ->with('followers', function($query) use ($offset, $limit) {
                        $query->orderBy('created_at', 'desc');
                        $query->offset($offset);
                        $query->limit($limit);
                    })
                    ->with('subscribers', function($query) use ($offset, $limit){
                        $query->orderBy('created_at', 'desc');
                        $query->offset($offset);
                        $query->limit($limit);
                    })
                    ->with('donations', function($query) use ($offset, $limit){
                        $query->orderBy('created_at', 'desc');
                        $query->offset($offset);
                        $query->limit($limit);
                    })
                    ->with('sales', function($query) use ($offset, $limit){
                        $query->orderBy('created_at', 'desc');
                        $query->offset($offset);
                        $query->limit($limit);
                    })
                    ->get();

    $allItems = collect();
    $allItems = $allItems->concat($activity[0]->sales);
    $allItems = $allItems->concat($activity[0]->donations);
    $allItems = $allItems->concat($activity[0]->followers);
    $allItems = $allItems->concat($activity[0]->subscribers);

    return $allItems->toJson();
  }
 
  public function getFollowerCount($request) {
    $validation_errors = $this->validateErrors($request);
    if($validation_errors){
      return $this->validateErrors($request);
    }

    $followerCount = Follower::where('user_id', $request->id)
                        ->whereDate('created_at', '>', Carbon::today()->subDays(30))
                        ->count();

    return $followerCount;
  }
 
  public function getTotalSales($request) {
    $validation_errors = $this->validateErrors($request);
    if($validation_errors){
      return $this->validateErrors($request);
    }

    $donation_total = Donation::where('user_id', $request->id)
        ->selectRaw('sum(amount) as total_donations')
        ->whereDate('created_at', '>', Carbon::today()->subDays(30))
        ->value('total_donations');

    $merch_total = MerchSale::where('user_id', $request->id)
        ->selectRaw('sum(amount) as total_merch')
        ->whereDate('created_at', '>', Carbon::today()->subDays(30))
        ->value('total_merch');

    $past30days = Carbon::today()->subDays(30);
    $tierValues = Config::get('streamlabsConstants.tiers');

    $subscriptions = Subscriber::where('user_id', $request->id)
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
  }
}