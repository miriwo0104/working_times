<?php

namespace App\Services;

use App\Repositories\DayRepositoryInterface as DayRepository;
use Carbon\Carbon;
use App\Models\Day;


class DayService
{

    /**
     * @var DayRepositoryInterface
     */
    private $dayRepository;

    public function __construct(
        DayRepository $dayRepository
    ) {
        $this->dayRepository = $dayRepository;
    }

    /**
     * daysテーブル登録
     *
     * @param array $daysInfo
     * @return Day|null
     */
    public function register(array $daysInfo) : ?Day
    {
        return $this->dayRepository->register($daysInfo);
    }

    public function getById(int $id) : ?Day
    {
        return $this->dayRepository->getById($id);
    }

    /**
     * 勤務中のdaysテーブルの情報を返す
     *
     * @param array $daysInfo
     * @return Day|null
     */
    public function getWorkingByUserIdAndDate(array $daysInfo) : ?Day
    {
        // 本日の日付がdays.dateに入っている時の情報取得
        $days = $this->dayRepository->getWorkingByUserIdAndDate($daysInfo);
        if (isset($days)) {
            return $days;
        }

        // 昨日の日付がdays.dateに入っている時の情報取得
        $daysInfo['date'] = Carbon::parse($daysInfo['date'])->subDay(config('const.day_num.one'))->format('Y/m/d');
        $days = $this->dayRepository->getWorkingByUserIdAndDate($daysInfo);

        return $days;
    }

    /**
     * 勤務中のdaysテーブルの情報を返す
     *
     * @param array $daysInfo
     * @return Day|null
     */
    public function getNotWorkingByUserIdAndDate(array $daysInfo) : ?Day
    {
        // 本日の日付がdays.dateに入っている時の情報取得
        $days = $this->dayRepository->getNotWorkingByUserIdAndDate($daysInfo);
        if (isset($days)) {
            return $days;
        }

        // 昨日の日付がdays.dateに入っている時の情報取得
        $daysInfo['date'] = Carbon::parse($daysInfo['date'])->subDay(config('const.day_num.one'))->format('Y/m/d');
        $days = $this->dayRepository->getNotWorkingByUserIdAndDate($daysInfo);

        return $days;
    }

    public function update(int $id, array $daysInfo)
    {
        $days = $this->getById($id);
        return $days->update($daysInfo);
    }
}
