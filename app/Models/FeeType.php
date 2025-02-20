<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'default_amount',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'fee_type_id', 'id');
    }
}
