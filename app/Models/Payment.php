<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

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

    public function getPaymentsByDates(array $dates, $type = "monthly")
    {
        $results = [];
        $processedDates = [];

        if (count($dates) == 0) {
            $dates = self::select('payment_date')->distinct()->get()->pluck('payment_date')->toArray();
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

            $paymentsQuery = self::with(['feeType', 'houseResident.house', 'houseResident.resident'])->whereYear('payment_date', $year);

            if ($type == 'monthly') {
                $paymentsQuery = $paymentsQuery->whereMonth('payment_date', $month);
            }

            $totalUnpaid = (clone $paymentsQuery)->where('payment_status', 'unpaid')->sum('amount');
            $totalPaid = (clone $paymentsQuery)->where('payment_status', 'paid')->sum('amount');

            $data = [
                'date' => $type == 'monthly' ? $monthYear : $year,
                'payment_total_unpaid' => $totalUnpaid,
                'payment_total_paid' => $totalPaid,
                'payments' => $paymentsQuery->get(),
            ];

            $results[] = $data;
            $processedDates[] = $type == 'monthly' ? $monthYear : $year;
        }

        return $results;
    }

    public function checkPaymentExist($houseResidentId, $date, $feeTypeId)
    {
        $date = Carbon::parse($date);
        $month = $date->month;
        $year = $date->year;

        $monthlyPayment = self::where('house_resident_id', $houseResidentId)
            ->where('fee_type_id', $feeTypeId)
            ->whereYear('payment_date', $year)
            ->whereMonth('payment_date', $month)
            ->first();

        if ($monthlyPayment) {
            return true;
        }

        $yearlyPayment = self::where('house_resident_id', $houseResidentId)
            ->where('fee_type_id', $feeTypeId)
            ->where('payment_period', 'yearly')
            ->where(function ($query) use ($year, $month) {
                $query->whereYear('payment_date', $year)
                    ->orWhere(function ($query) use ($year, $month) {
                        $query->whereYear('payment_date', $year - 1)
                            ->whereMonth('payment_date', '>=', $month);
                    });
            })
            ->first();

        if ($yearlyPayment) {
            return true;
        }

        return false;
    }
}
