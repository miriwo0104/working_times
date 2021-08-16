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
Route::middleware('auth')->prefix('time/management')->name('time.management.')->group(function(){
    // 出勤退勤休憩登録ページ
    Route::get('/index', [TimeManagementController::class, 'index'])
        ->name('index');

    // 出勤登録
    Route::post('/register/start/working', [TimeManagementController::class, 'registerStartWorking'])
        ->name('register_start_working');

    // 退勤登録
    Route::post('/register/end/working', [TimeManagementController::class, 'registerEndWorking'])
        ->name('register_end_working');
});