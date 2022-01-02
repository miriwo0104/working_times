<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Services\DayService;
use App\Services\WorkService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class ManagementService
{

    /**
     * @var DayService
     */
    private $dayService;

    /**
     * @var WorkService
     */
    private $workService;

    public function __construct(
        DayService $dayService,
        WorkService $workService
    ) {
        $this->dayService = $dayService;
        $this->workService = $workService;
    }

    /**
     * 出勤登録
     *
     * @param int $user_id
     * @param Carbon $today_date_info
     * @return DailyWorkInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function startWork()
    {
        try {
            DB::beginTransaction();

            $nowDateTime = Carbon::now();

            $daysInfo = [
                'user_id' => Auth::id(),
                'date' => $nowDateTime->format('Y/m/d'),
            ];
            $days = $this->dayService->register($daysInfo);
            
            $worksInfo = [
                'days_id' => $days->id,
                'start_date_time' => $nowDateTime->format('Y/m/d H:i:s'),
            ];
            $works = $this->workService->register($worksInfo);

            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return true;
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
        return $this->managementRpository->registerEndWork($user_id, $today_date_info);
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
        return $this->managementRpository->checkStartWork($user_id, $today_date_info);
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
        return $this->managementRpository->checkEndWork($user_id, $today_date_info);
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
        $daily_work_info = $this->managementRpository->getDailyWorkInfo($user_id, $today_date_info);
        
        if (!is_null($daily_work_info)) {
            // 休憩開始登録
            return $this->managementRpository->registerStartRest($user_id, $today_date_info, $daily_work_info);
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
        return $this->managementRpository->registerEndRest($user_id, $today_date_info);
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
        $daily_work_info = $this->managementRpository->getDailyWorkInfo($user_id, $today_date_info);
        
        if (!is_null($daily_work_info)) {
            return $this->managementRpository->checkStartRest($user_id, $today_date_info);
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
        $daily_work_info = $this->managementRpository->getDailyWorkInfo($user_id, $today_date_info);

        if (!is_null($daily_work_info)) {
            return $this->managementRpository->checkEndRest($user_id, $today_date_info);
        } else {
            return !is_null($daily_work_info);
        }
    }
}
