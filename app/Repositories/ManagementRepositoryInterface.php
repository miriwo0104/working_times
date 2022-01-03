<?php

namespace App\Repositories;

interface ManagementRepositoryInterface
{
    /**
     * 出勤登録
     *
     * @param int $user_id
     * @param Carbon $today_date_info
     * @return DailyWorkInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerStartWork($user_id, $today_date_info);

    /**
     * 退勤登録
     *
     * @param int $user_id
     * @param Carbon $today_date_info
     * @return DailyWorkInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerEndWork($user_id, $today_date_info);

    /**
     * 既に出勤登録されているかをチェックする
     * 出勤登録されていたらtrueを返す
     *
     * @param int $user_id
     * @param Carbon $today_date_info
     * @return bool
     */
    public function checkStartWork($user_id, $today_date_info);

    /**
     * 休憩開始登録
     *
     * @param int $user_id
     * @param Carbon $today_date_info
     * @param DailyWorkInfo|\Illuminate\Database\Eloquent\Model
     * @return DailyRestInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerStartRest($user_id, $today_date_info, $daily_work_info);

    /**
     * 休憩終了登録
     *
     * @param int $user_id
     * @param Carbon $today_date_info
     * @return DailyRestInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerEndRest($user_id, $today_date_info);

    /**
     * 既に休憩開始登録されているかをチェックする
     * 休憩開始登録されていたらtrueを返す
     *
     * @param int $user_id
     * @param Carbon $today_date_info
     * @return bool
     */
    public function checkStartRest($user_id, $today_date_info);
}
