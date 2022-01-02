<?php

namespace App\Repositories;

use App\Models\Rest;

class RestRepository implements RestRepositoryInterface
{
    /**
     * @var Rest
     */
    private $rest;

    public function __construct(
        Rest $rest
    ) {
        $this->rest = $rest;
    }

    /**
     * restsテーブル登録処理
     *
     * @param array $restsInfo
     * @return Rest|null
     */
    public function register(array $restsInfo) : ?Rest
    {   
        return $this->rest->create($restsInfo);
    }

    /**
     * idからレコードを取得して返す
     *
     * @param integer $id
     * @return Rest|null
     */
    public function getById(int $id) : ?Rest
    {
        return $this->rest->find($id);
    }

    /**
     * 退勤登録
     * 戻り値は影響を与えたレコード数
     *
     * @param array $restsInfo
     * @return integer
     */
    public function endRest(array $restsInfo) : int
    {
        $rests = $this->getById($restsInfo['id']);
        return $rests->update($restsInfo);
    }

    /**
     * days.idを使って勤務中のレコードを取得して返す
     *
     * @param integer $daysId
     * @return Rest|null
     */
    public function getByDaysId(int $daysId) : ?Rest
    {
        return $this->rest
                    ->where('days_id', $daysId)
                    ->whereNull('end_date_time')
                    ->first();
    }
}
