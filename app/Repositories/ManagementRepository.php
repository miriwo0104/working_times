<?php

namespace App\Repositories;

use App\Models\DailyWorkInfo;
use App\Models\RestInfo;
use Carbon\Carbon;

class ManagementRepository implements ManagementRepositoryInterface
{
    /**
     * @var DailyWorkInfo
     */
    private $dailyWorkInfo;

    /**
     * @var RestInfo
     */
    private $restInfo;

    public function __construct(
        DailyWorkInfo $dailyWorkInfo,
        RestInfo $restInfo
    ) {
        $this->dailyWorkInfo = $dailyWorkInfo;
        $this->restInfo = $restInfo;
    }

    /**
     * 出勤登録
     *
     * @param int $user_id
     * @param Carbon $today_date_info
     * @return DailyWorkInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerStartWork($user_id, $today_date_info)
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
     * @param Carbon $today_date_info
     * @return DailyWorkInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerEndWork($user_id, $today_date_info)
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
     * @param Carbon $today_date_info
     * @return bool
     */
    public function checkStartWork($user_id, $today_date_info)
    {
        return $this->dailyWorkInfo
            ->where('user_id', $user_id)
            ->where('date', $today_date_info->format('Y-m-d'))
            ->exists();
    }

    /**
     * 休憩開始登録
     *
     * @param int $user_id
     * @param Carbon $today_date_info
     * @param DailyWorkInfo|\Illuminate\Database\Eloquent\Model
     * @return DailyRestInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerStartRest($user_id, $today_date_info, $daily_work_info)
    {
        $rest_info = $this->restInfo;

        $rest_info->start_rest_at = $today_date_info->format('Y-m-d H:i:s');
        // リンクするdaily_work_infoテーブルのレコードのidを格納
        $rest_info->daily_work_infos_id = $daily_work_info->id;

        return $rest_info->save();
    }

    /**
     * 休憩終了登録
     *
     * @param int $user_id
     * @param Carbon $today_date_info
     * @return DailyRestInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerEndRest($user_id, $today_date_info)
    {
        $rest_info = $this->restInfo
            ->select('rest_infos.*')
            ->join('daily_work_infos', 'daily_work_infos.id', '=', 'rest_infos.daily_work_infos_id')
            ->where('daily_work_infos.user_id', $user_id)
            ->where('daily_work_infos.date', $today_date_info->format('Y-m-d'))
            ->whereNull('end_rest_at')
            ->first();

        // 登録済み休憩開始時間のCarbonインスタンス化
        $rest_start_at = new Carbon($rest_info->start_rest_at);
        // 出勤時間と退勤時間を比較して差分（分単位）の計算
        $total_rest_minutes = $rest_start_at->diffInMinutes($today_date_info->format('Y-m-d H:i:s'));
        $rest_info->total_rest_minutes = $total_rest_minutes;
        // 休憩終了時間の登録
        $rest_info->end_rest_at = $today_date_info->format('Y-m-d H:i:s');

        return $rest_info->save();
    }

    /**
     * ユーザーidと本日の日付情報からtoday_date_infoテーブルのレコード情報を返す
     *
     * @param int $user_id
     * @param Carbon $today_date_info
     * @return DailyWorkInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function getDailyWorkInfo($user_id, $today_date_info)
    {
        return $this->dailyWorkInfo
            ->where('user_id', $user_id)
            ->where('date', $today_date_info
            ->format('Y-m-d'))
            ->first();
    }

    /**
     * 既に休憩開始登録されているかをチェックする
     * 休憩開始登録されていたらtrueを返す
     *
     * @param int $user_id
     * @param Carbon $today_date_info
     * @return bool
     */
    public function checkStartRest($user_id, $today_date_info)
    {
        return $this->restInfo
            ->join('daily_work_infos', 'daily_work_infos.id', '=', 'rest_infos.daily_work_infos_id')
            ->where('daily_work_infos.user_id', $user_id)
            ->where('daily_work_infos.date', $today_date_info->format('Y-m-d'))
            ->whereNull('rest_infos.end_rest_at')
            ->exists();
    }
}
