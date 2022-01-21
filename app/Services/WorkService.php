<?php

namespace App\Services;

use App\Repositories\WorkRepository;
use App\Models\Work;
use Carbon\Carbon;

class WorkService
{

    /**
     * @var WorkRepositoryInterface
     */
    private $workRepository;

    public function __construct(
        WorkRepository $workRepository
    ) {
        $this->workRepository = $workRepository;
    }

    /**
     * worksテーブル登録
     *
     * @param array $worksInfo
     * @return Work|null
     */
    public function register(array $worksInfo) : ?Work
    {
        return $this->workRepository->register($worksInfo);
    }

    /**
     * 退勤処理
     *
     * @param array $worksInfo
     * @return Work|null
     */
    public function endWork(array $worksInfo) : int
    {
        $works = $this->getByDaysId($worksInfo['days_id']);

        if (isset($works)) {
            $worksInfo['id'] = $works->id;
            return $this->workRepository->endWork($worksInfo);
        } 

        return false;
    }

    /**
     * daysテーブルのidから勤務中のworksテーブルの情報を返す
     *
     * @param integer $days_id
     * @return Work|null
     */
    public function getByDaysId(int $days_id) : ?Work
    {
        return $this->workRepository->getByDaysId($days_id);
    }

    /**
     * 合計秒数を算出する
     *
     * @param integer $days_id
     * @return integer 
     */
    public function totalSeconds(int $days_id): int
    {
        $works = $this->workRepository->total($days_id);

        $total_time_seconds = config('const.variable_initial_value');
        foreach ($works as $work) {
            $startDateTime = new Carbon($work['start_date_time']);
            $endDateTime = new Carbon($work['end_date_time']);

            $total_time_seconds = $total_time_seconds + $startDateTime->diffInSeconds($endDateTime);
        }

        return $total_time_seconds;
    }
}
