<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyWorkInfo extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * daily_work_infosテーブル → usersテーブルのリレーション
     */
    public function users()
    {
        return $this->belongsTo('App\Models\User', 'id');
    }

    /**
     * daily_work_infosテーブル → rest_infosテーブルのリレーション
     */
    public function rest_infos()
    {
        return $this->hasMany('App\Models\RestInfo', 'daily_work_infos_id');
    }
}
