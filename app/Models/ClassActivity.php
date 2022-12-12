<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'mclass_id',
        'title',
        'instructions',
        'module',
        'score',
        'deadline',
        'status',
    ];

    protected $casts = [
        'instructions' => 'json'
    ];
}
