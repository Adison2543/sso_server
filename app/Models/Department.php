<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brn',
        'prefix',
    ];

    public function getBrn() {
        return $this->belongsTo(Branch::class, 'brn');
    }
}
