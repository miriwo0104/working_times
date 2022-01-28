<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Day;

class Work extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'days_id',
        'start_date_time',
        'end_date_time',
    ];

    /**
     * daysテーブルとのリレーション
     *
     */
    public function days()
    {
        return $this->belongsTo(Day::class, 'id', 'days_id');
    }
}
