<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * idからレコードを取得して返す
     *
     * @param integer $user_id
     * @return User|null
     */
    public function getById()
    {
        $user_id = Auth::id();
        return $this->userRepository->getById($user_id);
    }

    public function update(Request $request)
    {
        $requestBody = $request->validated();
        return $this->userRepository->update($requestBody);
    }
}
