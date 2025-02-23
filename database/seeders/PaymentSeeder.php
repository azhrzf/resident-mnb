<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HouseResident;
use App\Models\FeeType;
use App\Models\Payment;
use Pest\ArchPresets\Security;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $houseResidents = HouseResident::all();

        $securityFee = FeeType::where('name', 'Satpam')->first();
        $cleaningFee = FeeType::where('name', 'Kebersihan')->first();

        foreach ($houseResidents as $houseResident) {
            for ($i = 10; $i <= 12; $i++) {
                $currentMonth = $i < 10 ? "0$i" : $i;

                Payment::create([
                    'house_resident_id' => $houseResident->id,
                    'fee_type_id' => $securityFee->id,
                    'amount' => $securityFee->default_amount,
                    'payment_date' => "2024-$currentMonth-01",
                    'payment_status' => fake()->randomElement(['paid', 'unpaid']),
                    'payment_period' => 'monthly',
                ]);

                Payment::create([
                    'house_resident_id' => $houseResident->id,
                    'fee_type_id' => $cleaningFee->id,
                    'amount' => $cleaningFee->default_amount,
                    'payment_date' => "2024-$currentMonth-01",
                    'payment_status' => fake()->randomElement(['paid', 'unpaid']),
                    'payment_period' => 'monthly',
                ]);
            }

            for ($i = 1; $i <= 2; $i++) {
                $currentMonth = $i < 10 ? "0$i" : $i;

                Payment::create([
                    'house_resident_id' => $houseResident->id,
                    'fee_type_id' => $securityFee->id,
                    'amount' => $securityFee->default_amount,
                    'payment_date' => "2025-$currentMonth-01",
                    'payment_status' => fake()->randomElement(['paid', 'unpaid']),
                    'payment_period' => 'monthly',
                ]);

                Payment::create([
                    'house_resident_id' => $houseResident->id,
                    'fee_type_id' => $cleaningFee->id,
                    'amount' => $cleaningFee->default_amount,
                    'payment_date' => "2025-$currentMonth-01",
                    'payment_status' => fake()->randomElement(['paid', 'unpaid']),
                    'payment_period' => 'monthly',
                ]);
            }
        }
    }
}
