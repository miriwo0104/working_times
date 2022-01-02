<?php

namespace App\Repositories;

use App\Models\Day;

class DayRepository implements DayRepositoryInterface
{
    /**
     * @var Day
     */
    private $day;

    public function __construct(
        Day $day
    ) {
        $this->day = $day;
    }

    /**
     * daysテーブル登録処理
     *
     * @param array $daysInfo
     * @return Day|null
     */
    public function register(array $daysInfo) : ?Day
    {   
        return $this->day->create($daysInfo);
    }

    /**
     * idからレコードを取得して返す
     *
     * @param integer $id
     * @return Day|null
     */
    public function getById(int $id) : ?Day
    {
        return $this->day->find($id);
    }

    /**
     * ユーザーIDと日にち情報からレコードを取得して返す
     *
     * @param array $daysInfo
     * @return Day|null
     */
    public function getByUserIdAndDate(array $daysInfo) : ?Day
    {
        return $this->day
                    ->where('user_id', $daysInfo['user_id'])
                    ->where('working_flag', config(('const.flag.true')))
                    ->where('date', $daysInfo['date'])
                    ->first();
    }
}
