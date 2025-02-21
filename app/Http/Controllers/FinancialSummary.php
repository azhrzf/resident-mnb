<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Expense;

class FinancialSummary extends Controller
{
    public function showByMonth(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $payments = Payment::whereYear('payment_date', $year)
            ->whereMonth('payment_date', $month)
            ->get();

        $expenses = Expense::whereYear('expense_date', $year)
            ->whereMonth('expense_date', $month)
            ->get();

        $totalIncome = $payments->sum('amount');
        $totalExpense = $expenses->sum('amount');

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_income' => $totalIncome,
                'total_expense' => $totalExpense,
                'net_income' => $totalIncome - $totalExpense
            ]
        ]);
    }
}
