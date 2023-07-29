<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\Follower;
use App\Models\MerchSale;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    static public function run($user_id = 1): void
    {
        // dd($user_id);
        $user = User::where('id',$user_id)->first();
        // $user->factory()
        // ->hasFollowers(4)
        // ->hasSubscribers(4)
        // ->hasSales(4)
        // ->hasDonations(4)
        // ->create();
        
        // $user = User::factory()->create();
        Follower::factory()
                    ->count(10)
                    ->create(['user_id' => $user->id]);

        Subscriber::factory()
                    ->count(10)
                    ->create(['user_id' => $user->id]);

        MerchSale::factory()
                    ->count(10)
                    ->create(['user_id' => $user->id]);

        Donation::factory()
                    ->count(10)
                    ->create(['user_id' => $user->id]);

        
        // dd($user);
        // User::factory(1)
        // User::factory()->create(['id' => 'Our Specific Comment']);
        //     ->hasFollowers(4)
        //     ->hasSubscribers(4)
        //     ->hasSales(4)
        //     ->hasDonations(4)
        //     ->create();
    }
}
