<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MclassStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'mclass_id',
        'student_id',
    ];
}
