<?php

namespace App\Repositories;

use App\Models\Rest;

interface RestRepositoryInterface
{
    /**
     * restsテーブル登録処理
     *
     * @param array $restsInfo
     * @return Rest|null
     */
    public function register(array $restsInfo) : ?Rest;

    /**
     * idからレコードを取得して返す
     *
     * @param integer $id
     * @return Rest|null
     */
    public function getById(int $id) : ?Rest;

    /**
     * 退勤登録
     * 戻り値は影響を与えたレコード数
     *
     * @param array $restsInfo
     * @return integer
     */
    public function endRest(array $restsInfo) : int;

    /**
     * days.idを使って勤務中のレコードを取得して返す
     *
     * @param integer $daysId
     * @return Rest|null
     */
    public function getByDaysId(int $daysId) : ?Rest;
}
