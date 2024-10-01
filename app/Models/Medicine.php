<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $table = "medcines";

    protected $fillable = [
        'med_name',
        'quantity',
        'keywords',
        'pharmacy_id',
        'price'
    ];
}
