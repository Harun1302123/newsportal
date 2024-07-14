<?php

use App\Modules\WebPortal\Http\Controllers\NoticeController;
use Illuminate\Support\Facades\Route;
use App\Modules\Dashboard\Http\Controllers\DashboardController;

Route::group(array('Module'=>'Dashboard', 'middleware' => ['web','auth','GlobalSecurity']), function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

});

Route::group(array('module' => 'WebPortal', 'middleware' => ['web', 'auth']), function () {
    Route::prefix('notices')->group(function () {
        Route::post('list-data', [DashboardController::class, 'noticeData'])->name('notices.data');
        Route::get( 'view/{id}', [DashboardController::class, 'view'])->name('notices.view');
    });
});
