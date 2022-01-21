<?php

namespace App\Services;

use App\Repositories\DayRepository;
use Carbon\Carbon;
use App\Models\Day;
use Illuminate\Database\Eloquent\Collection;

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
     * idからdaysテーブルの情報を返す
     *
     * @param integer $id
     * @return Day|null
     */
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
        // days.dateカラムを更新してほしくないので値削除
        if (isset($daysInfo['date'])) {
            unset($daysInfo['date']);
        }
        return $this->dayRepository->update($id, $daysInfo);
    }

    /**
     * 本日を含む過去の勤怠情報を返す
     *
     * @param array $daysInfo
     * @return Collection|null
     */
    public function getPastByUserIdAndDate(array $daysInfo) : ?Collection
    {
        return $this->dayRepository->getPastByUserIdAndDate($daysInfo);
    }
}
