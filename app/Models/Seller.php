<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'selling_option',
        'first_name',
        'middle_name',
        'last_name',
        'dob',
        'nationality',
        'street_address',
        'city',
        'country',
        'postal_code',
        'main_photo_1',
        'main_photo_2',
    ];
}
