<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Pharmacy extends Model
{
    use  HasFactory, HasApiTokens;

    protected $table = "pharmacies";
    protected $fillable = [
        'name',
        'city',
        'address',
        'map_url',
        'image_url',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'password',
    ];
}
