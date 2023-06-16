<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'f_name', 'l_name', 'other_name', 'email', 'mobile_contact', 'home_contact', 'dob',
        'joining_date', 'next_of_kin', 'next_of_kin_contact'
    ];
}
