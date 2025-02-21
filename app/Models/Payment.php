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
    
        foreach ($dates as $date) {
            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));
    
            $paymentsQuery = self::with(['feeType'])->whereYear('payment_date', $year);
    
            if ($type === 'complete') {
                $paymentsQuery = $paymentsQuery->whereMonth('payment_date', $month);
            }
    
            $totalUnpaid = (clone $paymentsQuery)->where('payment_status', 'unpaid')->sum('amount');
            $totalPaid = (clone $paymentsQuery)->where('payment_status', 'paid')->sum('amount');
    
            $data = [
                'year' => $year,
                'total_unpaid' => $totalUnpaid,
                'total_paid' => $totalPaid,
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
