<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use App\Models\House;
use App\Models\Resident;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HouseResident>
 */
class HouseResidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'house_id' => House::factory(),
            'resident_id' => Resident::factory(),
            'date_of_entry' => fake()->date(),
            'date_of_exit' => Carbon::now(),
        ];
    }
}
