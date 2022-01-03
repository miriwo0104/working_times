<?php

namespace App\Services;

use App\Repositories\RestRepositoryInterface as RestRepository;
use App\Models\Rest;

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
}
