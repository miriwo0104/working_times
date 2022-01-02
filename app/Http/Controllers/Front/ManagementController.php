<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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
        return view('front/managements/index');
    }

    /**
     * 出勤登録
     *
     * @return DailyWorkInfo|\Illuminate\Database\Eloquent\Model|null
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
     * @return DailyWorkInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerEndWork()
    {
        $user_id = Auth::id();
        $today_date_info = Carbon::now();

        // 既に退勤登録されているか確認
        if ($this->managementService->checkStartWork($user_id, $today_date_info)) {
            // 退勤登録
            $this->managementService->registerEndWork($user_id, $today_date_info);
        }
        
        return redirect(route('time.management.index'));
    }

    /**
     * 休憩開始登録
     *
     * @return RestInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerStartRest()
    {
        $user_id = Auth::id();
        $today_date_info = Carbon::now();

        if ((!$this->managementService->checkStartRest($user_id, $today_date_info)) && ($this->managementService->checkStartWork($user_id, $today_date_info))) {
            // 休憩開始登録
            $this->managementService->registerStartRest($user_id, $today_date_info);
        }

        return redirect(route('time.management.index'));
    }


    /**
     * 休憩終了登録
     *
     * @return RestInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerEndRest()
    {
        $user_id = Auth::id();
        $today_date_info = Carbon::now();
        $a = $this->managementService->checkStartRest($user_id, $today_date_info);

        if (($this->managementService->checkStartRest($user_id, $today_date_info)) && ($this->managementService->checkStartWork($user_id, $today_date_info))) {
            // 休憩終了登録
            $this->managementService->registerEndRest($user_id, $today_date_info);
        }

        return redirect(route('time.management.index'));
    }
}
