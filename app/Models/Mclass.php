<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mclass extends Model
{
    use HasFactory;

    public static $colors = [
        'blue',
        'green',
        'pink',
        'orange',
        'cyan',
        'purple',
        'lightblue',
        'grey',
    ];

    protected $fillable = [
        'name',
        'subject',
        'description',
        'teacher',
        'class_color',
        'code'
    ];
}
