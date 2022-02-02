<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\ManagementController;
use App\Http\Controllers\Front\UserController;
use App\Services\ManagementService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

// 認証必須
Route::group(['middleware' => 'auth'], function(){
    // 勤怠系
    Route::group(['prefix' => 'management', 'as' => 'management.'], function(){
        Route::get('/index', [ManagementController::class, 'index'])->name('index'); // 出勤退勤休憩登録ページ
        Route::post('/register/start/work', [ManagementController::class, 'startWork'])->name('start.work'); // 出勤登録
        Route::post('/register/end/work', [ManagementController::class, 'endWork'])->name('end.work'); // 退勤登録
        Route::post('/register/start/rest', [ManagementController::class, 'startRest'])->name('start.rest'); // 休憩開始登録
        Route::post('/register/end/rest', [ManagementController::class, 'endRest'])->name('end.rest'); // 休憩終了登録
        Route::get('/detail/{days_id}', [ManagementController::class, 'detail'])->name('detail'); // 日毎の詳細ページ
        Route::get('/edit/input/rest/{rests_id}', [ManagementController::class, 'editInputRest'])->name('edit.input.rest'); // 休憩編集ページ
        Route::get('/edit/input/work/{works_id}', [ManagementController::class, 'editInputWork'])->name('edit.input.work'); // 勤務編集ページ
    });
    // ユーザー系
    Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
        Route::get('/setting', [UserController::class, 'setting'])->name('setting'); // 設定
        Route::post('/setting/update', [UserController::class, 'update'])->name('setting.update'); // 設定
    });
});
