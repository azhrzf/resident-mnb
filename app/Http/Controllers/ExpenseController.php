<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Http\Requests\StoreExpenseRequest;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with([
            'expenseCategory',
        ])->get();

        return response()->json([
            'status' => 'success',
            'data' => $expenses
        ]);
    }

    public function showDetail($id)
    {
        $expense = Expense::with([
            'expenseCategory',
        ])->where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $expense
        ]);
    }

    public function showByDate(Request $request)
    {
        $payment = new Expense();

        $dates = $request->input('dates');
        $type = $request->input('type');

        $data = $payment->getExpensesByDate($dates, $type);

        return response()->json([
            'status' => 'success',
            'data' => $data
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
