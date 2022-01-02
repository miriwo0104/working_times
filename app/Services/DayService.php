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

    /**
     * 勤務中のdaysテーブルの情報を返す
     *
     * @param array $daysInfo
     * @return Day|null
     */
    public function getByUserIdAndDate(array $daysInfo) : ?Day
    {
        // 本日の日付がdays.dateに入っている時の情報取得
        $days = $this->dayRepository->getByUserIdAndDate($daysInfo);
        if (isset($days)) {
            return $days;
        }

        // 昨日の日付がdays.dateに入っている時の情報取得
        $daysInfo['date'] = Carbon::parse($daysInfo['date'])->subDay(config('const.day_num.one'))->format('Y/m/d');
        $days = $this->dayRepository->getByUserIdAndDate($daysInfo);

        if (isset($days)) {
            return $days;
        } else {
            return false;
        }
    }
}
