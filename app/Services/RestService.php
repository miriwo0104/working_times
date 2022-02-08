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
     * @param integer $days_id
     * @return Rest|null
     */
    public function getByDaysId(int $days_id) : ?Rest
    {
        return $this->restRepository->getByDaysId($days_id);
    }

    /**
     * restsテーブルのidからレコードを1件取得して返す
     *
     * @param integer $rests_id
     * @return Rest|null
     */
    public function getById(int $rests_id) : ?Rest
    {
        return $this->restRepository->getById($rests_id);
    }

    /**
     * 合計秒数を算出する
     *
     * @param integer $days_id
     * @return integer $total_time_seconds
     */
    public function totalSeconds(int $days_id) : int
    {
        $rests = $this->restRepository->total($days_id)->toArray();

        $total_time_seconds = config('const.variable_initial_value');
        foreach ($rests as $rest) {
            $startDateTime = new Carbon($rest['start_date_time']);
            $endDateTime = new Carbon($rest['end_date_time']);

            $total_time_seconds = $total_time_seconds + $startDateTime->diffInSeconds($endDateTime);
        }

        return $total_time_seconds;
    }

    /**
     * 休憩情報更新処理
     *
     * @param integer $rests_id
     * @param array $restInfo
     * @return boolean
     */
    public function update(int $rests_id, array $restInfo) : bool
    {
        return $this->restRepository->update($rests_id, $restInfo);
    }
}
