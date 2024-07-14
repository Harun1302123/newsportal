<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Goals\Http\Controllers\GoalController;
use App\Modules\Goals\Http\Controllers\GoalTrackingController;

Route::group(array('module' => 'Goals', 'middleware' => ['web', 'auth', 'XssProtection', 'checkAdmin']), function () {
    Route::prefix('goals')->group(function () {
        Route::match(['get', 'post'], 'list', [GoalController::class, 'index'])->name('goals.list');
        Route::post('store', [GoalController::class, 'store'])->name('goals.store');
        Route::get('edit/{id}', [GoalController::class, 'edit'])->name('goals.edit');
    });
    Route::prefix('goal-trackings')->group(function () {
        Route::match(['get', 'post'], 'list', [GoalTrackingController::class, 'index'])->name('goal_trackings.list');
        Route::get('view/{id}', [GoalTrackingController::class, 'view'])->name('goal_trackings.view');
        Route::get('excel/{id}', [GoalTrackingController::class, 'excel'])->name('goal_trackings.excel')->withoutMiddleware('checkAdmin');
        Route::get('edit/{id}', [GoalTrackingController::class, 'edit'])->name('goal_trackings.edit');
        Route::get('create', [GoalTrackingController::class, 'create'])->name('goals.create');
        Route::get('goal-tracking-form', [GoalTrackingController::class, 'goalTrackingForm'])->name('goals.goal_tracking_form')->withoutMiddleware('checkAdmin');
        Route::post('store-goal-tracking-data', [GoalTrackingController::class, 'storeGoalTrackingData'])->name('goals.store_goal_tracking_data')->withoutMiddleware('checkAdmin');
        Route::post('publish-goal-tracking-data', [GoalTrackingController::class, 'publishGoalTrackingData'])->name('goals.publish_goal_tracking_data')->withoutMiddleware('checkAdmin');
    });
});
