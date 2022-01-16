<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(
        UserService $userService
    ){
        $this->userService = $userService;  
    }

    /**
     * ユーザー設定画面表示
     *
     * @return view
     */
    public function setting()
    {
        $user = $this->userService->getById();
        return view('front.users.setting', ['user' => $user]);
    }

    /**
     * ユーザー設定情報更新
     *
     * @param UserRequest $request
     * @return view
     */
    public function update(UserRequest $request)
    {
        $this->userService->update($request);
        return redirect(route('user.setting'));
    }
}
