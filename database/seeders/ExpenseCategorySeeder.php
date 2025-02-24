<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExpenseCategory::create([
            'name' => 'Perbaikan Jalan',
            'description' => 'Perbaikan Jalan',
            'default_amount' => 50000,
        ]);

        ExpenseCategory::create([
            'name' => 'Perbaikan Selokan',
            'description' => 'Perbaikan Selokan',
            'default_amount' => 50000,
        ]);

        ExpenseCategory::create([
            'name' => 'Gaji Satpam',
            'description' => 'Gaji Satpam',
            'default_amount' => 2000000,
        ]);

        ExpenseCategory::create([
            'name' => 'Biaya Token Listrik Pos Satpam',
            'description' => 'Biaya Token Listrik Pos Satpam',
            'default_amount' => 100000,
        ]);

        ExpenseCategory::create([
            'name' => 'Lain-lain',
            'description' => 'Lain-lain',
            'default_amount' => 0,
        ]);
    }
}
