<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscriber>
 */
class SubscriberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_date = Carbon::now()->subMonths(3)->format('Y-m-d H:i:s');
        $end_date = Carbon::now()->format('Y-m-d H:i:s');
        return [
            'name' => fake()->name(),
            'subscription_tier' => fake()->numberBetween(1,3),
            'created_at' => fake()->dateTimeBetween($start_date, $end_date)
        ];
    }
}
