<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestInfo extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * rest_infosテーブル → daily_work_infosテーブルのリレーション
     */
    public function daily_work_infos()
    {
        return $this->belongsTo('App\Models\DailyWorkInfo', 'id');
    }
}
