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
     * @param string $today_date
     * @return DailyWorkInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerStartWorking($user_id, $today_date_info)
    {
        if (!$this->timeManagementRpository->checkStartWorking($user_id, $today_date_info)) {
            return $this->timeManagementRpository->registerStartWorking($user_id, $today_date_info);
        }
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
        return $this->timeManagementRpository->registerEndWorking($user_id, $today_date_info);
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
        return $this->timeManagementRpository->checkStartWorking($user_id, $today_date_info);
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
        return $this->timeManagementRpository->checkEndWorking($user_id, $today_date_info);
    }
}
