<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\House;
use App\Models\Resident;
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
        $houses = House::all();
        $residents = Resident::all();

        $securityFee = FeeType::where('name', 'Satpam')->first();
        $cleaningFee = FeeType::where('name', 'Kebersihan')->first();

        foreach ($houses as $index => $house) {
            if (isset($residents[$index])) {
                Payment::create([
                    'house_id' => $house->id,
                    'resident_id' => $residents[$index]->id,
                    'fee_type_id' => $securityFee->id,
                    'amount' => $securityFee->default_amount,
                    'payment_date' => '2025-01-01',
                    'payment_period' => 'monthly',
                    'payment_status' => 'paid',
                ]);

                Payment::create([
                    'house_id' => $house->id,
                    'resident_id' => $residents[$index]->id,
                    'fee_type_id' => $cleaningFee->id,
                    'amount' => $cleaningFee->default_amount,
                    'payment_date' => '2025-01-01',
                    'payment_period' => 'monthly',
                    'payment_status' => 'paid',
                ]);

                Payment::create([
                    'house_id' => $house->id,
                    'resident_id' => $residents[$index]->id,
                    'fee_type_id' => $securityFee->id,
                    'amount' => $securityFee->default_amount,
                    'payment_date' => '2025-02-01',
                    'payment_period' => 'monthly',
                    'payment_status' => 'unpaid',
                ]);

                Payment::create([
                    'house_id' => $house->id,
                    'resident_id' => $residents[$index]->id,
                    'fee_type_id' => $cleaningFee->id,
                    'amount' => $cleaningFee->default_amount,
                    'payment_date' => '2025-02-01',
                    'payment_period' => 'monthly',
                    'payment_status' => 'unpaid',
                ]);
            }
        }
    }
}
