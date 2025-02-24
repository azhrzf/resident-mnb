<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'expense_category_id',
        'amount',
        'expense_date',
        'expense_period',
    ];

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id', 'id');
    }

    public function getExpensesByDates(array $dates, $type = "")
    {
        $results = [];
        $processedDates = [];

        if (count($dates) == 0) {
            $dates = self::select('expense_date')->distinct()->get()->pluck('expense_date')->toArray();
            $type = 'complete';
        }

        foreach ($dates as $date) {
            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));
            $monthYear = "$month/$year";

            if (in_array($monthYear, $processedDates)) {
                continue;
            }

            $expensesQuery = self::with(['expenseCategory'])->whereYear('expense_date', $year);

            if ($type == 'complete') {
                $expensesQuery = $expensesQuery->whereMonth('expense_date', $month);
            }

            $total = (clone $expensesQuery)->sum('amount');

            $data = [
                'date' => $type == 'complete' ? $monthYear : $year,
                'year' => $year,
                'expense_total' => $total,
                'expenses' => $expensesQuery->get(),
            ];

            if ($type == 'complete') {
                $data['month'] = $month;
            }

            $results[] = $data;
            $processedDates[] = $monthYear; 
        }

        return $results;
    }
}
