<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Http\Requests\StoreExpenseRequest;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $payment = new Expense();

        $dates = $request->query('dates', []);
        $type = $request->query('type');

        $data = $payment->getExpensesByDates($dates, $type);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function showDetail($id)
    {
        $expense = Expense::with([
            'expenseCategory',
        ])->orderBy('expense_date', 'desc')->where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $expense
        ]);
    }

    public function store(StoreExpenseRequest $request)
    {
        $validatedData = $request->validated();
        $expense = Expense::create($validatedData);

        return response()->json([
            'status' => 'success',
            'data' => $expense
        ], 201);
    }
}
