<?php

namespace App\Repositories;

use App\Models\Rest;
use Illuminate\Database\Eloquent\Collection;

class RestRepository implements RestRepositoryInterface
{
    /**
     * @var Rest
     */
    private $rest;

    public function __construct(
        Rest $rest
    ) {
        $this->rest = $rest;
    }

    /**
     * restsテーブル登録処理
     *
     * @param array $restsInfo
     * @return Rest|null
     */
    public function register(array $restsInfo) : ?Rest
    {   
        return $this->rest->create($restsInfo);
    }

    /**
     * idからレコードを取得して返す
     *
     * @param integer $rests_id
     * @return Rest|null
     */
    public function getById(int $rests_id) : ?Rest
    {
        return $this->rest->find($rests_id);
    }

    /**
     * 退勤登録
     * 戻り値は影響を与えたレコード数
     *
     * @param array $restsInfo
     * @return integer
     */
    public function endRest(array $restsInfo) : int
    {
        $rests = $this->getById($restsInfo['id']);
        return $rests->update($restsInfo);
    }

    /**
     * days.idを使って休憩中のレコードを取得して返す
     *
     * @param integer $days_id
     * @return Rest|null
     */
    public function getByDaysId(int $days_id) : ?Rest
    {
        return $this->rest
                    ->where('days_id', $days_id)
                    ->whereNull('end_date_time')
                    ->first();
    }

    /**
     * days.idに紐づく休憩情報返す
     *
     * @param integer $days_id
     * @return Collection|null
     */
    public function total(int $days_id) : ?Collection
    {
        return $this->rest
                    ->where('days_id', $days_id)
                    ->get();
    }
}
