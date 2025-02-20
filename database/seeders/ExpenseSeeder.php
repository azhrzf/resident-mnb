<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Expense;
use App\Models\ExpenseCategory;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $roadRepair = ExpenseCategory::where('name', 'Perbaikan Jalan')->first();
        $gutterRepair = ExpenseCategory::where('name', 'Perbaikan Selokan')->first();
        $securitySalary = ExpenseCategory::where('name', 'Gaji Satpam')->first();
        $securityElectricity = ExpenseCategory::where('name', 'Biaya Token Listrik Pos Satpam')->first();

        Expense::create([
            'expense_category_id' => $roadRepair->id,
            'amount' => $roadRepair->default_amount,
            'expense_date' => '2025-01-01',
            'expense_period' => 'irregular',
        ]);

        Expense::create([
            'expense_category_id' => $gutterRepair->id,
            'amount' => $gutterRepair->default_amount,
            'expense_date' => '2025-01-01',
            'expense_period' => 'irregular',
        ]);

        Expense::create([
            'expense_category_id' => $securitySalary->id,
            'amount' => $securitySalary->default_amount,
            'expense_date' => '2025-01-01',
            'expense_period' => 'monthly',
        ]);

        Expense::create([
            'expense_category_id' => $securityElectricity->id,
            'amount' => $securityElectricity->default_amount,
            'expense_date' => '2025-01-01',
            'expense_period' => 'monthly',
        ]);
    }
}
