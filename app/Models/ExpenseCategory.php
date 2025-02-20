<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
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

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expense_category_id', 'id');
    }
}
