<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\TimeManagementController;

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
Route::middleware('auth')->prefix('time/management')->name('time.management.')->group(function () {
    // 出勤退勤休憩登録ページ
    Route::get('/index', [TimeManagementController::class, 'index'])
        ->name('index');

    // 出勤登録
    Route::post('/register/start/work', [TimeManagementController::class, 'registerStartWork'])
        ->name('register_start_work');

    // 退勤登録
    Route::post('/register/end/work', [TimeManagementController::class, 'registerEndWork'])
        ->name('register_end_work');

    // 休憩開始登録
    Route::post('/register/start/rest', [TimeManagementController::class, 'registerStartRest'])
        ->name('register_start_rest');

    // 休憩終了登録
    Route::post('/register/end/rest', [TimeManagementController::class, 'registerEndRest'])
        ->name('register_end_rest');
});
