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
}
