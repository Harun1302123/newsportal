<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Targets\Http\Controllers\TargetController;


Route::group(array('module' => 'Targets', 'middleware' => ['web', 'auth','XssProtection', 'checkAdmin']), function () {
    Route::prefix('targets')->group(function () {
        Route::match(['get', 'post'], 'list', [TargetController::class, 'index'])->name('targets.list');
        Route::get('create', [TargetController::class, 'create'])->name('targets.create');
        Route::post('store', [TargetController::class, 'store'])->name('targets.store');
        Route::get('edit/{id}', [TargetController::class, 'edit'])->name('targets.edit');
    });
});

Route::group(array('module' => 'Targets', 'middleware' => ['web', 'auth', 'XssProtection']), function () {
    Route::get('targets/unique-target-check', 'TargetController@uniqueTargetCheck');
});
