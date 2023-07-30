<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $currencies = ['CDN','USD','EUR','GBP','JPY','AUD'];
        $cost = fake()->numberBetween(1,100).'.'.fake()->numberBetween(1,100);
        $start_date = Carbon::now()->subMonths(3)->format('Y-m-d H:i:s');
        $end_date = Carbon::now()->format('Y-m-d H:i:s');
        return [
            'name' => fake()->name(),
            'amount' => $cost,
            'currency' => $currencies[array_rand($currencies)],
            'message' => fake()->sentence(),
            'created_at' => fake()->dateTimeBetween($start_date, $end_date)
        ];
    }
}
