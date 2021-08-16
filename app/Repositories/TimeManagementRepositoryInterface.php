<?php

namespace App\Repositories;

interface TimeManagementRepositoryInterface
{
    /**
     * 出勤登録
     *
     * @param int $user_id
     * @param string $today_date
     * @return DailyWorkInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerStartWork($user_id, $today_date_info);

    /**
     * 退勤登録
     *
     * @param int $user_id
     * @param string $today_date
     * @return DailyWorkInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerEndWork($user_id, $today_date_info);

    /**
     * 既に出勤登録されているかをチェックする
     * 出勤登録されていたらtrueを返す
     *
     * @param int $user_id
     * @param string $today_date
     * @return bool
     */
    public function checkStartWork($user_id, $today_date_info);

    /**
     * 既に退勤登録されているかをチェックする
     * 退勤登録されていたらtrueを返す
     *
     * @param int $user_id
     * @param string $today_date
     * @return bool
     */
    public function checkEndWork($user_id, $today_date_info);
}
