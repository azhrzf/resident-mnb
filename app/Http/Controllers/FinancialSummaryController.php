<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Payment;

class FinancialSummaryController extends Controller
{
    public function index(Request $request)
    {
        $results = [];
        $processedDates = [];

        $dates = $request->query('dates', []);
        $type = $request->query('type');

        if (count($dates) == 0) {
            $dates = Payment::select('payment_date')->distinct()->get()->pluck('payment_date')->toArray();
            $type = 'complete';
        }

        foreach ($dates as $date) {
            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));
            $monthYear = "$month/$year";

            if (in_array($monthYear, $processedDates)) {
                continue;
            }

            $paymentsQuery = Payment::with(['feeType', 'houseResident.house', 'houseResident.resident'])->whereYear('payment_date', $year);
            $expensesQuery = Expense::with(['expenseCategory'])->whereYear('expense_date', $year);

            if ($type == 'complete') {
                $paymentsQuery = $paymentsQuery->whereMonth('payment_date', $month);
                $expensesQuery = $expensesQuery->whereMonth('expense_date', $month);
            }

            $paymentTotalUnpaid = (clone $paymentsQuery)->where('payment_status', 'unpaid')->sum('amount');
            $paymentTotalPaid = (clone $paymentsQuery)->where('payment_status', 'paid')->sum('amount');
            $expenseTotal = (clone $expensesQuery)->sum('amount');

            $data = [
                'date' => $type == 'complete' ? "$month/$year" : $year,
                'year' => $year,
                'payment_total_unpaid' => $paymentTotalUnpaid,
                'payment_total_paid' => $paymentTotalPaid,
                'payments' => $paymentsQuery->get(),
                'expense_total' => $expenseTotal,
                'expenses' => $expensesQuery->get(),
            ];

            if ($type == 'complete') {
                $data['month'] = $month;
            }

            $results[] = $data;
            $processedDates[] = $monthYear; 
        }

        return response()->json([
            'status' => 'success',
            'data' => $results
        ]);
    }
}
