<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSignup extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'signup_token',
        'activated'
    ];

    protected $hidden = [];
}
