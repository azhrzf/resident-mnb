<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'house_resident_id',
        'fee_type_id',
        'amount',
        'payment_date',
        'payment_period',
        'payment_status',
    ];

    public function houseResident()
    {
        return $this->belongsTo(HouseResident::class, 'house_resident_id', 'id');
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class, 'fee_type_id', 'id');
    }

    public function getPaymentsByDates(array $dates, $type = "")
    {
        $results = [];
        $processedDates = [];

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

            $paymentsQuery = self::with(['feeType', 'houseResident.house', 'houseResident.resident'])->whereYear('payment_date', $year);

            if ($type == 'complete') {
                $paymentsQuery = $paymentsQuery->whereMonth('payment_date', $month);
            }

            $totalUnpaid = (clone $paymentsQuery)->where('payment_status', 'unpaid')->sum('amount');
            $totalPaid = (clone $paymentsQuery)->where('payment_status', 'paid')->sum('amount');

            $data = [
                'date' => $type == 'complete' ? "$month/$year" : $year,
                'year' => $year,
                'payment_total_unpaid' => $totalUnpaid,
                'payment_total_paid' => $totalPaid,
                'payments' => $paymentsQuery->get(),
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
