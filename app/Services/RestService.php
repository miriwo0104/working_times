<?php

namespace App\Services;

use App\Repositories\RestRepository;
use App\Models\Rest;
use Carbon\Carbon;

class RestService
{

    /**
     * @var RestRepositoryInterface
     */
    private $restRepository;

    public function __construct(
        RestRepository $restRepository
    ) {
        $this->restRepository = $restRepository;
    }

    /**
     * restsテーブル登録
     *
     * @param array $restsInfo
     * @return Rest|null
     */
    public function register(array $restsInfo) : ?Rest
    {
        return $this->restRepository->register($restsInfo);
    }

    /**
     * 退勤処理
     *
     * @param array $restsInfo
     * @return Rest|null
     */
    public function endWork(array $restsInfo) : int
    {
        $rests = $this->getByDaysId($restsInfo['days_id']);

        if (isset($rests)) {
            $restsInfo['id'] = $rests->id;
            return $this->restRepository->endWork($restsInfo);
        } 

        return false;
    }

    /**
     * 
     *
     * @param array $restsInfo
     * @return Rest|null
     */
    public function endRest(array $restsInfo) : int
    {
        $rests = $this->getByDaysId($restsInfo['days_id']);

        if (isset($rests)) {
            $restsInfo['id'] = $rests->id;
            return $this->restRepository->endRest($restsInfo);
        } 

        return false;
    }

    /**
     * daysテーブルのidから勤務中のrestsテーブルの情報を返す
     *
     * @param integer $daysId
     * @return Rest|null
     */
    public function getByDaysId(int $daysId) : ?Rest
    {
        return $this->restRepository->getByDaysId($daysId);
    }

    /**
     * 合計秒数を算出する
     *
     * @param integer $daysId
     * @return integer $total_time_seconds
     */
    public function totalSeconds(int $daysId) : int
    {
        $rests = $this->restRepository->total($daysId)->toArray();

        $total_time_seconds = config('const.variable_initial_value');
        foreach ($rests as $rest) {
            $startDateTime = new Carbon($rest['start_date_time']);
            $endDateTime = new Carbon($rest['end_date_time']);

            $total_time_seconds = $total_time_seconds + $startDateTime->diffInSeconds($endDateTime);
        }

        return $total_time_seconds;
    }
}
