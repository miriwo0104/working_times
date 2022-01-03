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
                'resting_flag' => config('const.flag.false'),
                'date' => $nowDateTime->format('Y-m-d'),
            ];
            // 今日既に出勤登録が行われているかのチェック
            $days = $this->dayService->getNotWorkingByUserIdAndDate($daysInfo);
            
            // 日毎の就業データの登録
            if (isset($days)) {
                // 既に出勤登録されていた場合、情報更新
                $this->dayService->update($days->id, $daysInfo);
            } else {
                // まだ出勤登録されていない場合、作成
                $days = $this->dayService->register($daysInfo);
            }
            
            $worksInfo = [
                'days_id' => $days->id,
                'start_date_time' => $nowDateTime->format('Y-m-d H:i:s'),
            ];
            // 個別の就業データの登録
            $this->workService->register($worksInfo);

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
     */
    public function endWork()
    {
        try {
            DB::beginTransaction();

            $nowDateTime = Carbon::now();

            $daysInfo = [
                'user_id' => Auth::id(),
                'date' => $nowDateTime->format('Y-m-d'),
                'working_flag' => config('const.flag.false'),
            ];
            // 出勤中の日毎の就業データを取得
            $days = $this->dayService->getWorkingByUserIdAndDate($daysInfo);
            // 日毎の就業データの退勤登録
            $result = $this->dayService->update($days->id, $daysInfo);

            $worksInfo = [
                'days_id' => $days->id,
                'end_date_time' => $nowDateTime->format('Y-m-d H:i:s'),
            ];
            // 個別の就業データの退勤登録
            $this->workService->endWork($worksInfo);

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
                'resting_flag' => config('const.flag.true'),
            ];
            // 出勤中の日毎の就業データを取得
            $days = $this->dayService->getWorkingByUserIdAndDate($daysInfo);
            // 日毎の就業データの休憩開始登録
            $this->dayService->update($days->id, $daysInfo);

            $restsInfo = [
                'days_id' => $days->id,
                'start_date_time' => $nowDateTime->format('Y-m-d H:i:s'),
            ];
            // 休憩データの開始登録
            $this->restService->register($restsInfo);

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
                'resting_flag' => config('const.flag.false'),
            ];
            // 出勤中の日毎の就業データを取得
            $days = $this->dayService->getWorkingByUserIdAndDate($daysInfo);
            // 日毎の就業データの休憩終了登録
            $this->dayService->update($days->id, $daysInfo);

            $restsInfo = [
                'days_id' => $days->id,
                'end_date_time' => $nowDateTime->format('Y-m-d H:i:s'),
            ];
            // 休憩データの終了登録
            $this->restService->endRest($restsInfo);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return true;
    }

    /**
     * 本日 or 昨日出勤してから退勤していない日毎の就業データを返す
     *
     * @return Day|null
     */
    public function getDays()
    {
        try {
            $nowDateTime = Carbon::now();
    
            $daysInfo = [
                'user_id' => Auth::id(),
                'date' => $nowDateTime->format('Y-m-d'),
            ];
            $days = $this->dayService->getWorkingByUserIdAndDate($daysInfo);

        } catch (\Throwable $th) {
            throw $th;
        }

        return $days;
    }
}
