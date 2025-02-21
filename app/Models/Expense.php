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

    public function getPaymentsByDates(array $dates, $type = "")
    {
        $results = [];

        foreach ($dates as $date) {
            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));

            $paymentsQuery = self::with(['expenseCategory'])->whereYear('payment_date', $year);

            if ($type === 'complete') {
                $paymentsQuery = $paymentsQuery->whereMonth('payment_date', $month);
            }

            $total = (clone $paymentsQuery)->sum('amount');

            $data = [
                'year' => $year,
                'total' => $total,
                'payments' => $paymentsQuery->get(),
            ];

            if ($type === 'complete') {
                $data['month'] = $month;
            }

            $results[] = $data;
        }

        return $results;
    }
}
