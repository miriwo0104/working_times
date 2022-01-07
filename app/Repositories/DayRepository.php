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
     * ユーザーIDと日にち情報から出勤中のレコードを取得して返す
     *
     * @param array $daysInfo
     * @return Day|null
     */
    public function getWorkingByUserIdAndDate(array $daysInfo) : ?Day
    {
        return $this->day
                    ->where('user_id', $daysInfo['user_id'])
                    ->where('working_flag', config(('const.flag.true')))
                    ->where('date', $daysInfo['date'])
                    ->first();
    }

    /**
     * ユーザーIDと日にち情報から出勤中のレコードを取得して返す
     *
     * @param array $daysInfo
     * @return Day|null
     */
    public function getNotWorkingByUserIdAndDate(array $daysInfo) : ?Day
    {
        return $this->day
                    ->where('user_id', $daysInfo['user_id'])
                    ->where('working_flag', config('const.flag.false'))
                    ->where('date', $daysInfo['date'])
                    ->first();
    }

    /**
     * daysテーブルの更新
     * 更新に影響を与えたレコード数を返す
     *
     * @param integer $id
     * @param array $daysInfo
     * @return integer|null
     */
    public function update(int $id, array $daysInfo) : ?int
    {
        $days = $this->getById($id);
        return $days->update($daysInfo);
    }

    /**
     * 本日を含む過去の勤怠情報を返す
     *
     * @param array $daysInfo
     * @return array|null
     */
    public function getPastByUserIdAndDate(array $daysInfo) : ?array
    {
        return $this->day
                    ->where('user_id', $daysInfo['user_id'])
                    ->where('working_flag', config('const.flag.false'))
                    ->where('resting_flag', config('const.flag.false'))
                    ->where('date', '<=' ,$daysInfo['date'])
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->toArray();
    }
}
