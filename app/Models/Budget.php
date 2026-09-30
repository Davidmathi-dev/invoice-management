<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'period_type', 'amount', 'start_date', 'end_date', 'description'];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
