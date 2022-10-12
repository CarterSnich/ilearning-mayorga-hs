<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRegistration extends Model
{
    use HasFactory;

    // fillable
    protected $fillable = [
        // credentials
        'username',
        'password',

        // name
        'lastname',
        'firstname',
        'middlename',

        // contact information
        'email',
        'phone_number',

        // enrollment information
        'section',
        'year_level',

        // registration information
        'status'
    ];

    // hidden
    protected $hidden = [];
}
