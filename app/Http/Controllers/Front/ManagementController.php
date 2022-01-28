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
        $days = $this->managementService->getWorkingDays();
        $pastDays = $this->managementService->getPastDays();
        return view('front/managements/index', [
            'days' => $days,
            'pastDays' => $pastDays,
        ]);
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

    /**
     * 休憩開始登録
     *
     */
    public function startRest()
    {
        $registerResult = $this->managementService->startRest();

        if ($registerResult) {
            return redirect(route('management.index'));
        } else {
            return '保存失敗';
        }
    }

    /**
     * 休憩終了登録
     *
     */
    public function endRest()
    {
        $registerResult = $this->managementService->endRest();

        if ($registerResult) {
            return redirect(route('management.index'));
        } else {
            return '保存失敗';
        }
    }

    /**
     * 勤怠詳細ページ
     *
     * @param integer $days_id
     * @return void
     */
    public function detail(int $days_id)
    {
        $days = $this->managementService->getDays($days_id);

        if (isset($days)) {
            return view('front.managements.detail', ['days' => $days]);
        } else {
            return '表示データ取得失敗';
        }
    }
}
