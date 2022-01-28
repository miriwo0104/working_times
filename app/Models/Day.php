<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Work;
use App\Models\Rest;

class Day extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'working_flag',
        'resting_flag',
        'date',
        'total_work_seconds',
        'total_rest_seconds',
        'total_actual_work_seconds',
        'total_overtime_seconds',
    ];

    /**
     * worksテーブルとのリレーション
     *
     */
    public function works()
    {
        return $this->hasMany(Work::class, 'days_id');
    }

    /**
     * restsテーブルとのリレーション
     *
     */
    public function rests()
    {
        return $this->hasMany(Rest::class, 'days_id');
    }
}
