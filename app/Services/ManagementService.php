<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Services\DayService;
use App\Services\WorkService;
use App\Services\RestService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Day;
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
        // 時間の算出
        $this->dayTotal($days->id);
        return true;
    }

    public function dayTotal(int $daysId)
    {
        try {
            DB::beginTransaction();

            $days = $this->dayService->getById($daysId);

            // 現時点での仕事の合計時間（秒）
            $worksTotalTimeSeconds = $this->workService->totalSeconds($daysId);
            // 現時点での休憩の合計時間（秒）
            $restsTotalTimeSeconds = $this->restService->totalSeconds($daysId);
            // 実働時間算出
            $actualWorkTimeSeconds = $worksTotalTimeSeconds - $restsTotalTimeSeconds;

            $daysInfo = [
                'total_work_seconds' => $worksTotalTimeSeconds,
                'total_rest_seconds' => $restsTotalTimeSeconds,
                'total_actual_work_seconds' => $actualWorkTimeSeconds,
            ];
            $this->dayService->update($daysId, $daysInfo);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
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

            if (isset($days)) {
                $days['works'] = $this->workService->getByDaysId($days->id);
                $days['rests'] = $this->restService->getByDaysId($days->id);
            }

        } catch (\Throwable $th) {
            throw $th;
        }

        return $days;
    }

    /**
     * 本日を含む過去の勤怠情報を返す
     *
     * @return array|null
     */
    public function getPastDays() : ?array
    {
        try {

            $nowDateTime = Carbon::now();

            $daysInfo = [
                'user_id' => Auth::id(),
                'date' => $nowDateTime->format('Y-m-d'),
            ];

            $pastDays = $this->dayService->getPastByUserIdAndDate($daysInfo);

            // 秒数 → 時間への変換
            if (isset($pastDays)) {
                foreach ($pastDays as &$pastDay) {
                    $pastDay['total_work_hour'] = $this->convertSecondsToHour($pastDay['total_work_seconds']);
                    $pastDay['total_actual_work_hour'] = $this->convertSecondsToHour($pastDay['total_actual_work_seconds']);
                    $pastDay['total_rest_hour'] = $this->convertSecondsToHour($pastDay['total_rest_seconds']);
                }
            }

        } catch (\Throwable $th) {
            throw $th;
        }

        return $pastDays;
    }

    /**
     * 秒数を時間に直す
     * 時間は少数第二位までのfloadで返す
     *
     * @param integer $seconds
     * @return float
     */
    public function convertSecondsToHour(int $seconds) : float
    {
        $hour = $seconds / config('const.time.hour_as_seconds');
        return round($hour, config('const.convert_second_to_hour.round_num'));
    }
}
