<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Day;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rest extends Model
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
