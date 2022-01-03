<?php

namespace App\Repositories;

use App\Models\Day;

interface DayRepositoryInterface
{
    /**
     * daysテーブル登録処理
     *
     * @param array $daysInfo
     * @return Day|null
     */
    public function register(array $info) : ?Day;

    /**
     * idからレコードを取得して返す
     *
     * @param integer $id
     * @return Day|null
     */
    public function getById(int $id) : ?Day;

    /**
     * ユーザーIDと日にち情報から出勤中のレコードを取得して返す
     *
     * @param array $daysInfo
     * @return Day|null
     */
    public function getWorkingByUserIdAndDate(array $daysInfo) : ?Day;

    /**
     * ユーザーIDと日にち情報から出勤中のレコードを取得して返す
     *
     * @param array $daysInfo
     * @return Day|null
     */
    public function getNotWorkingByUserIdAndDate(array $daysInfo) : ?Day;
}

