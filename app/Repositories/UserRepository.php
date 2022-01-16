<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;

class UserRepository //implements UserRepositoryInterface
{
    /**
     * @var User
     */
    private $user;

    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    /**
     * ユーザーidからレコードを取得して返す
     *
     * @param integer $user_id
     * @return User|null
     */
    public function getById(int $user_id) : ?User
    {
        return $this->user->find($user_id);
    }

    /**
     * ユーザー情報更新
     *
     * @param array $requestBody
     * @return integer
     */
    public function update(array $requestBody) : int
    {
        $user = $this->getById($requestBody['user_id']);
        return $user->update($requestBody);
    }
}