<?php

namespace App\Repositories;

use App\Models\DailyWorkInfo;
use Carbon\Carbon;

class TimeManagementRepository implements TimeManagementRepositoryInterface
{
    /**
     * @var DailyWorkInfo
     */
    private $dailyWorkInfo;

    public function __construct(
        DailyWorkInfo $dailyWorkInfo
    )
    {
        $this->dailyWorkInfo = $dailyWorkInfo;
    }

    /**
     * 出勤登録
     *
     * @param int $user_id
     * @param string $today_date
     * @return DailyWorkInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerStartWorking($user_id, $today_date_info)
    {
        $daily_work_info = $this->dailyWorkInfo;

        $daily_work_info->user_id = $user_id;
        $daily_work_info->date = $today_date_info->format('Y-m-d');
        $daily_work_info->start_work_at = $today_date_info->format('Y-m-d H:i:s');

        return $daily_work_info->save();
    }

    /**
     * 退勤登録
     *
     * @param int $user_id
     * @param string $today_date
     * @return DailyWorkInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerEndWorking($user_id, $today_date_info)
    {
        $daily_work_info = $this->dailyWorkInfo
            ->where('user_id', $user_id)
            ->first();

        // 退勤時間の登録
        $daily_work_info->end_work_at = $today_date_info->format('Y-m-d H:i:s');

        // 登録済み出勤時間のCarbonインスタンス化
        $daily_work_start_at = new Carbon($daily_work_info->start_work_at);
        // 出勤時間と退勤時間を比較して差分（分単位）の計算
        $daily_total_work_minutes = $daily_work_start_at->diffInMinutes($today_date_info->format('Y-m-d H:i:s'));
        $daily_work_info->daily_total_work_minutes = $daily_total_work_minutes;

        return $daily_work_info->save();
    }

    /**
     * 既に出勤登録されているかをチェックする
     * 出勤登録されていたらtrueを返す
     *
     * @param int $user_id
     * @param string $today_date
     * @return bool
     */
    public function checkStartWorking($user_id, $today_date_info)
    {
        return $this->dailyWorkInfo
            ->where('user_id', $user_id)
            ->where('date', $today_date_info->format('Y-m-d'))
            ->exists();
    }

    /**
     * 既に退勤登録されているかをチェックする
     * 退勤登録されていたらtrueを返す
     *
     * @param int $user_id
     * @param string $today_date
     * @return bool
     */
    public function checkEndWorking($user_id, $today_date_info)
    {
        return $this->dailyWorkInfo
            ->where('user_id', $user_id)
            ->where('date', $today_date_info->format('Y-m-d'))
            ->whereNotNull('end_work_at')
            ->exists();
    }
}