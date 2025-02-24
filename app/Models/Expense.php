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

    public function getExpensesByDates(array $dates, $type = "monthly")
    {
        $results = [];
        $processedDates = [];

        if (count($dates) == 0) {
            $dates = self::select('expense_date')->distinct()->get()->pluck('expense_date')->toArray();
            $type = 'monthly';
        }

        foreach ($dates as $date) {
            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));
            $monthYear = "$month/$year";

            if ($type == 'monthly' && in_array($monthYear, $processedDates)) {
                continue;
            } elseif ($type == 'yearly' && in_array($year, $processedDates)) {
                continue;
            }

            $expensesQuery = self::with(['expenseCategory'])->whereYear('expense_date', $year);

            if ($type == 'monthly') {
                $expensesQuery = $expensesQuery->whereMonth('expense_date', $month);
            }

            $total = (clone $expensesQuery)->sum('amount');

            $data = [
                'date' => $type == 'monthly' ? $monthYear : $year,
                'expense_total' => $total,
                'expenses' => $expensesQuery->get(),
            ];

            $results[] = $data;
            $processedDates[] = $type == 'monthly' ? $monthYear : $year;
        }

        return $results;
    }
}
