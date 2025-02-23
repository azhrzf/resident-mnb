<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\Resident;
use App\Models\HouseResident;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HouseResidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $houses = House::all();
        $residents = Resident::all();

        foreach ($houses as $index => $house) {
            if (isset($residents[$index])) {
                HouseResident::create([
                    'house_id' => $house->id,
                    'resident_id' => $residents[$index]->id,
                    'date_of_entry' => '2024-10-01',
                    'date_of_exit' => null,
                ]);
            }
        }
    }
}
