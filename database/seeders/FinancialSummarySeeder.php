<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FinancialSummary;
use App\Models\Payment;
use App\Models\Expense;
use Carbon\Carbon;

class FinancialSummarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $year = 2025;
        $month = 1;

        $totalIncome = Payment::where('payment_status', 'paid')
            ->whereYear('payment_date', $year)->whereMonth('payment_date', $month)->sum('amount');
        $totalExpense = Expense::whereYear('expense_date', $year)->whereMonth('expense_date', $month)->sum('amount');
        $closingBalance = $totalIncome - $totalExpense;

        FinancialSummary::create([
            'summary_date' => Carbon::create($year, $month, 31),
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'closing_balance' => $closingBalance,
        ]);
    }
}
