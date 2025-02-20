<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Resident;
use App\Models\HouseResident;
use App\Models\Payment;
use App\Models\FeeType;

class House extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'house_number',
        'occupancy_status',
    ];

    public function houseResidents()
    {
        return $this->hasMany(HouseResident::class, 'house_id', 'id');
    }

    public static function getHouseDetail($id)
    {
        $house = House::with([
            'houseResidents.resident', 
            'houseResidents.payments.feeType'
        ])->where('id', $id)->first();
    
        return $house;
    }
}
