<?php

namespace App\Services;

use App\Repositories\WorkRepositoryInterface as WorkRepository;
use App\Models\Work;

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
     * @param integer $daysId
     * @return Work|null
     */
    public function getByDaysId(int $daysId) : ?Work
    {
        return $this->workRepository->getByDaysId($daysId);
    }
}
