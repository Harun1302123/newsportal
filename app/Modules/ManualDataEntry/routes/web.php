<?php

use App\Modules\ManualDataEntry\Http\Controllers\MefBenchmarkRecordController;
use App\Modules\ManualDataEntry\Http\Controllers\MefIndicatorDataController;
use App\Modules\ManualDataEntry\Http\Controllers\MefSetwiselDataController;
use App\Modules\ManualDataEntry\Http\Controllers\MefGoalMaximumScoreRecordController;
use Illuminate\Support\Facades\Route;

Route::group(array('module' => 'ManualDataEntry	', 'middleware' => ['web', 'auth', 'XssProtection', 'checkAdmin']), function () {

    Route::prefix('mef-indicator-data')->group(function () {
        Route::match(['get', 'post'], 'list', [MefIndicatorDataController::class, 'index'])->name('mef_indicator_data.list');
        Route::get('create', [MefIndicatorDataController::class, 'create'])->name('mef_indicator_data.create');
        Route::post('store', [MefIndicatorDataController::class, 'store'])->name('mef_indicator_data.store');
        Route::get('edit/{id}', [MefIndicatorDataController::class, 'edit'])->name('mef_indicator_data.edit');
        Route::get('view/{id}', [MefIndicatorDataController::class, 'view'])->name('mef_indicator_data.view')->withoutMiddleware('checkAdmin');
    });

    Route::prefix('mef-setwise-data')->group(function () {
        Route::match(['get', 'post'], 'list', [MefSetwiselDataController::class, 'index'])->name('mef_setwise_data.list');
        Route::get('create', [MefSetwiselDataController::class, 'create'])->name('mef_setwise_data.create');
        Route::post('store', [MefSetwiselDataController::class, 'store'])->name('mef_setwise_data.store');
        Route::get('edit/{id}', [MefSetwiselDataController::class, 'edit'])->name('mef_setwise_data.edit');
        Route::get('view/{id}', [MefSetwiselDataController::class, 'view'])->name('mef_setwise_data.view')->withoutMiddleware('checkAdmin');
    });

    Route::prefix('mef-goal-max-score-record')->group(function () {
        Route::match(['get', 'post'], 'list', [MefGoalMaximumScoreRecordController::class, 'index'])->name('mef_max_score_record.list');
        Route::get('create', [MefGoalMaximumScoreRecordController::class, 'create'])->name('mef_max_score_record.create');
        Route::post('store', [MefGoalMaximumScoreRecordController::class, 'store'])->name('mef_max_score_record.store');
        Route::get('edit/{id}', [MefGoalMaximumScoreRecordController::class, 'edit'])->name('mef_max_score_record.edit');
        Route::get('view/{id}', [MefGoalMaximumScoreRecordController::class, 'view'])->name('mef_max_score_record.view')->withoutMiddleware('checkAdmin');
    });

    Route::prefix('mef-benchmark-record')->group(function () {
        Route::match(['get', 'post'], 'list', [MefBenchmarkRecordController::class, 'index'])->name('mef_benchmark_record.list');
        Route::get('create', [MefBenchmarkRecordController::class, 'create'])->name('mef_benchmark_record.create');
        Route::post('store', [MefBenchmarkRecordController::class, 'store'])->name('mef_benchmark_record.store');
        Route::get('edit/{id}', [MefBenchmarkRecordController::class, 'edit'])->name('mef_benchmark_record.edit');
        Route::get('view/{id}', [MefBenchmarkRecordController::class, 'view'])->name('mef_benchmark_record.view')->withoutMiddleware('checkAdmin');
    });
});

Route::group(array('prefix' => 'manual-data-entry', 'middleware' => ['web', 'auth', 'XssProtection']), function () {
    Route::group(['prefix' => 'common-api/v1/'], function () {
    });
});
