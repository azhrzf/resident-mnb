<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FeeType;

class FeeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FeeType::create([
            'name' => 'Satpam',
            'description' => 'Iuran satpam',
            'default_amount' => 100000,
        ]);

        FeeType::create([
            'name' => 'Kebersihan',
            'description' => 'Iuran kebersihan',
            'default_amount' => 15000,
        ]);
    }
}
