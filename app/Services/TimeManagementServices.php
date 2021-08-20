<?php

namespace App\Services;

use App\Repositories\TimeManagementRepositoryInterface as TimeManagementRepository;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TimeManagementServices
{

    /**
     * @var TimeManagementRepositoryInterface
     */
    private $timeManagementRpository;

    public function __construct(
        TimeManagementRepository $timeManagementRpository
    )
    {
        $this->timeManagementRpository = $timeManagementRpository;
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
        if (!$this->timeManagementRpository->checkStartWork($user_id, $today_date_info)) {
            return $this->timeManagementRpository->registerStartWork($user_id, $today_date_info);
        }
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
        return $this->timeManagementRpository->registerEndWork($user_id, $today_date_info);
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
        return $this->timeManagementRpository->checkStartWork($user_id, $today_date_info);
    }

    /**
     * 既に退勤登録されているかをチェックする
     * 退勤登録されていたらtrueを返す
     *
     * @param int $user_id
     * @param Carbon $today_date_info
     * @return bool
     */
    public function checkEndWork($user_id, $today_date_info)
    {
        return $this->timeManagementRpository->checkEndWork($user_id, $today_date_info);
    }

    /**
     * 休憩開始登録
     *
     * @param int $user_id
     * @param Carbon $today_date_info
     * @return DailyRestInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerStartRest($user_id, $today_date_info)
    {
        $daily_work_info = $this->timeManagementRpository->getDailyWorkInfo($user_id, $today_date_info);
        
        if (!is_null($daily_work_info)) {
            // 休憩開始登録
            return $this->timeManagementRpository->registerStartRest($user_id, $today_date_info, $daily_work_info);
        }
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
        return $this->timeManagementRpository->registerEndRest($user_id, $today_date_info);
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
        $daily_work_info = $this->timeManagementRpository->getDailyWorkInfo($user_id, $today_date_info);
        
        if (!is_null($daily_work_info)) {
            return $this->timeManagementRpository->checkStartRest($user_id, $today_date_info);
        } else {
            return !is_null($daily_work_info);
        }
    }

    /**
     * 既に休憩終了登録されているかをチェックする
     * 休憩終了登録されていたらtrueを返す
     *
     * @param int $user_id
     * @param Carbon $today_date_info
     * @return bool
     */
    public function checkEndRest($user_id, $today_date_info)
    {
        $daily_work_info = $this->timeManagementRpository->getDailyWorkInfo($user_id, $today_date_info);

        if (!is_null($daily_work_info)) {
            return $this->timeManagementRpository->checkEndRest($user_id, $today_date_info);
        } else {
            return !is_null($daily_work_info);
        }
    }
}
