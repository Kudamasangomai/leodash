<?php

namespace Database\Factories;

use App\Models\Fault;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Repair>
 */
class RepairFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'truck_id' => Truck::factory(),
            'fault_id' => Fault::factory(),
            'user_id'  => User::factory(),
            'status' => 'pending',
        ];
    }
}
