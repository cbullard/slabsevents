<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Follower;
use App\Models\MerchSale;
use App\Models\Subscriber;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory(1)
            ->hasFollowers(4)
            ->hasSubscribers(4)
            ->hasSales(4)
            ->hasDonations(4)
            ->create();

        // factory(App\Customer::class, 10)->create()->each(function ($customer) {
        //     // Seed the relation with one address
        //     $address = factory(App\CustomerAddress::class)->make();
        //     $customer->address()->save($address);

        //     // Seed the relation with 5 purchases
        //     $purchases = factory(App\CustomerPurchase::class, 5)->make();
        //     $customer->purchases()->saveMany($purchases);
        // });
    }
}
