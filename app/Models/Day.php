<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Day extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'working_flag',
        'resting_flag',
        'date',
        'total_work_seconds',
        'total_rest_seconds',
        'total_actual_work_seconds',
    ];
}
