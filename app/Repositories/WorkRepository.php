<?php

namespace App\Repositories;

use App\Models\Work;

class WorkRepository implements WorkRepositoryInterface
{
    /**
     * @var Work
     */
    private $work;

    public function __construct(
        Work $work
    ) {
        $this->work = $work;
    }

    /**
     * worksテーブル登録処理
     *
     * @param array $worksInfo
     * @return Work|null
     */
    public function register(array $worksInfo) : ?Work
    {   
        return $this->work->create($worksInfo);
    }

    /**
     * idからレコードを取得して返す
     *
     * @param integer $id
     * @return Work|null
     */
    public function getById(int $id) : ?Work
    {
        return $this->work->find($id);
    }

    /**
     * 退勤登録
     * 戻り値は影響を与えたレコード数
     *
     * @param array $worksInfo
     * @return integer
     */
    public function endWork(array $worksInfo) : int
    {
        $works = $this->getById($worksInfo['id']);
        return $works->update($worksInfo);
    }

    /**
     * days.idを使って勤務中のレコードを取得して返す
     *
     * @param integer $daysId
     * @return Work|null
     */
    public function getByDaysId(int $daysId) : ?Work
    {
        return $this->work
                    ->where('days_id', $daysId)
                    ->whereNull('end_date_time')
                    ->first();
    }

    /**
     * days.idに紐づく勤務情報を返す
     *
     * @param integer $daysId
     * @return Work|null
     */
    public function total(int $daysId)
    {
        return $this->work
                    ->where('days_id', $daysId)
                    ->get();
    }
}