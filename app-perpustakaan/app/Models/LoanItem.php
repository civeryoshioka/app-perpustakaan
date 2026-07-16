<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'loan_id',
        'book_id',
    ];
}
