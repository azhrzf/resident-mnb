<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\House;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            House::factory()->create([
                'occupancy_status' => 'occupied',
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            House::factory()->create([
                'occupancy_status' => 'unoccupied',
            ]);
        }
    }
}
