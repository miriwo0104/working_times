<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\ManagementService;

class ManagementController extends Controller
{

    /**
     * @var ManagementService
     */
    private $managementService;

    public function __construct(
        ManagementService $managementService
    ) {
        $this->managementService = $managementService;
    }

    /**
     * 出勤退勤休憩登録ページ
     *
     * @return view front\times\index
     */
    public function index()
    {
        $days = $this->managementService->getDays();
        return view('front/managements/index', ['days' => $days]);
    }


    /**
     * 出勤登録
     *
     */
    public function startWork()
    {
        $registerResult = $this->managementService->startWork();

        if ($registerResult) {
            return redirect(route('management.index'));
        } else {
            return '保存失敗';
        }
    }

    /**
     * 退勤登録
     *
     */
    public function endWork()
    {
        $updateResult = $this->managementService->endWork();

        if ($updateResult) {
            return redirect(route('management.index'));
        } else {
            return '更新失敗';
        }
    }

    public function startRest()
    {
        $registerResult = $this->managementService->startRest();

        if ($registerResult) {
            return redirect(route('management.index'));
        } else {
            return '保存失敗';
        }
    }

    public function endRest()
    {
        $registerResult = $this->managementService->endRest();

        if ($registerResult) {
            return redirect(route('management.index'));
        } else {
            return '保存失敗';
        }
    }
}
