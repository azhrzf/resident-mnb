<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $expenseCategories = ExpenseCategory::all();

        return response()->json([
            'status' => 'success',
            'data' => $expenseCategories
        ]);
    }
}
