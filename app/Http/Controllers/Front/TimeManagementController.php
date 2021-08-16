<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Services\TimeManagementServices;

class TimeManagementController extends Controller
{

    /**
     * @var TimeManagementServices
     */
    private $timeManagementServices;

    public function __construct(
        TimeManagementServices $timeManagementServices
    )
    {
        $this->timeManagementServices = $timeManagementServices;
    }

    /**
     * 出勤退勤休憩登録ページ
     *
     * @return view front\times\index
     */
    public function index()
    {
        return view('front/times/index');
    }

    /**
     * 出勤登録
     *
     * @return DailyWorkInfo|\Illuminate\Database\Eloquent\Model|null
     */
    public function registerStartWork()
    {
        $user_id = Auth::id();
        $today_date_info = Carbon::now();
        
        // 既に出勤登録されているか確認
        if (!$this->timeManagementServices->checkStartWork($user_id, $today_date_info)) {
            // 出勤登録
            $this->timeManagementServices->registerStartWork($user_id, $today_date_info);
        }
        
        return redirect(route('time.management.index'));
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
        if (!$this->timeManagementServices->checkEndWork($user_id, $today_date_info)) {
            // 退勤登録
            $this->timeManagementServices->registerEndWork($user_id, $today_date_info);
        }
        
        return redirect(route('time.management.index'));
    }
}
