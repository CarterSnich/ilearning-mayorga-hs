<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        // credentials
        'teacher_id',
        'password',

        // name
        'lastname',
        'firstname',
        'middlename',

        // basic information
        'gender',
        'date_of_birth',
        'address',

        // contact information
        'email',
        'phone_number',

        // picture
        'picture'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];
}
