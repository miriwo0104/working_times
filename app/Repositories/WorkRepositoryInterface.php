<?php

namespace App\Repositories;

use App\Models\Work;

interface WorkRepositoryInterface
{
    /**
     * worksテーブル登録処理
     *
     * @param array $worksInfo
     * @return Work|null
     */
    public function register(array $worksInfo) : ?Work;

    /**
     * idからレコードを取得して返す
     *
     * @param integer $id
     * @return Work|null
     */
    public function getById(int $id) : ?Work;

    /**
     * 退勤登録
     * 戻り値は影響を与えたレコード数
     *
     * @param array $worksInfo
     * @return integer
     */
    public function endWork(array $worksInfo) : int;
    
    /**
     * days.idを使って勤務中のレコードを取得して返す
     *
     * @param integer $daysId
     * @return Work|null
     */
    public function getByDaysId(int $daysId) : ?Work;
}
