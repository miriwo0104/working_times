<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * ユーザーidからレコードを取得して返す
     *
     * @param integer $user_id
     * @return User|null
     */
    public function getById(int $user_id) : ?User;

    /**
     * ユーザー情報更新
     *
     * @param array $requestBody
     * @return integer
     */
    public function update(array $requestBody) : int;
}

