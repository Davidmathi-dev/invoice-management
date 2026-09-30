<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['budget_id', 'category', 'description', 'amount', 'expense_date'];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
