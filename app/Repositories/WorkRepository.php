<?php

namespace App\Repositories;

use App\Models\Work;
use Illuminate\Database\Eloquent\Collection;

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
     * @param integer $works_id
     * @return Work|null
     */
    public function getById(int $works_id) : ?Work
    {
        return $this->work->find($works_id);
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
     * @param integer $days_id
     * @return Work|null
     */
    public function getByDaysId(int $days_id) : ?Work
    {
        return $this->work
                    ->where('days_id', $days_id)
                    ->whereNull('end_date_time')
                    ->first();
    }

    /**
     * days.idに紐づく勤務情報を返す
     *
     * @param integer $days_id
     * @return Collection|null
     */
    public function total(int $days_id) : ?Collection
    {
        return $this->work
                    ->where('days_id', $days_id)
                    ->get();
    }

    /**
     * 勤務情報更新処理
     *
     * @param integer $works_id
     * @param array $worksInfo
     * @return boolean
     */
    public function update(int $works_id, array $worksInfo) : bool
    {
        $works = $this->getById($works_id);
        return $works->update($worksInfo);
    }
}