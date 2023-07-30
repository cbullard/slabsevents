<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\Follower;
use App\Models\MerchSale;
use App\Models\Subscriber;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    static public function run($user_id = 1, $table = null): void
    {
        if(!in_array($table, ['followers', 'subscribers', 'sales', 'donations'])) {
            dd('Allowed table names: followers, subscribers, sales, donations');
            return;
        }

        $user = User::where('id',$user_id)->first();
        
        if($user == null) {
            dd('User not found');
            return;
        }

        $seedQuantity = 300;

        switch ($table) {
            case 'followers':
                Follower::factory()
                            ->count($seedQuantity)
                            ->create(['user_id' => $user->id]);
                break;
            case 'subscribers':
                Subscriber::factory()
                            ->count($seedQuantity)
                            ->create(['user_id' => $user->id]);
                break;
            case 'sales':
                MerchSale::factory()
                            ->count($seedQuantity)
                            ->create(['user_id' => $user->id]);
                break;
            case 'donations':
                Donation::factory()
                            ->count($seedQuantity)
                            ->create(['user_id' => $user->id]);
                break;
        }
    }
}
