<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'nim',
        'email',
        'nomor_telepon',
        'alamat',
        'status',
    ];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
