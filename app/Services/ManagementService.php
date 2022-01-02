<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Services\DayService;
use App\Services\WorkService;
use App\Services\RestService;
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

    /**
     *
     * @var RestService
     */
    private $restService;

    public function __construct(
        DayService $dayService,
        WorkService $workService,
        RestService $restService
    ) {
        $this->dayService = $dayService;
        $this->workService = $workService;
        $this->restService = $restService;
    }

    /**
     * 出勤登録
     *
     * @return boolean
     */
    public function startWork() : bool
    {
        try {
            DB::beginTransaction();

            $nowDateTime = Carbon::now();

            $daysInfo = [
                'user_id' => Auth::id(),
                'working_flag' => config('const.flag.true'),
                'date' => $nowDateTime->format('Y-m-d'),
            ];
            $days = $this->dayService->register($daysInfo);
            
            $worksInfo = [
                'days_id' => $days->id,
                'start_date_time' => $nowDateTime->format('Y-m-d H:i:s'),
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
     * @return boolean
     */
    public function endWork() : bool
    {
        try {
            DB::beginTransaction();

            $nowDateTime = Carbon::now();

            $daysInfo = [
                'user_id' => Auth::id(),
                'date' => $nowDateTime->format('Y-m-d'),
            ];
            $days = $this->dayService->getByUserIdAndDate($daysInfo);

            $worksInfo = [
                'days_id' => $days->id,
                'end_date_time' => $nowDateTime->format('Y-m-d H:i:s'),
            ];
            $works = $this->workService->endWork($worksInfo);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return true;
    }

    /**
     * 休憩開始登録
     *
     * @return boolean
     */
    public function startRest() : bool
    {
        try {
            DB::beginTransaction();

            $nowDateTime = Carbon::now();
            
            $daysInfo = [
                'user_id' => Auth::id(),
                'date' => $nowDateTime->format('Y-m-d'),
            ];
            $days = $this->dayService->getByUserIdAndDate($daysInfo);

            $restsInfo = [
                'days_id' => $days->id,
                'start_date_time' => $nowDateTime->format('Y-m-d H:i:s'),
            ];
            $rests = $this->restService->register($restsInfo);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return true;
    }

    /**
     * 休憩終了登録
     *
     * @return boolean
     */
    public function endRest() : bool
    {
        try {
            DB::beginTransaction();

            $nowDateTime = Carbon::now();
            
            $daysInfo = [
                'user_id' => Auth::id(),
                'date' => $nowDateTime->format('Y-m-d'),
            ];
            $days = $this->dayService->getByUserIdAndDate($daysInfo);

            $restsInfo = [
                'days_id' => $days->id,
                'end_date_time' => $nowDateTime->format('Y-m-d H:i:s'),
            ];
            $rests = $this->restService->endRest($restsInfo);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return true;
    }
}
