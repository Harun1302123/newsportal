<?php

use App\Modules\Polls\Http\Controllers\PollController;
use Illuminate\Support\Facades\Route;

Route::group(array('module' => 'Polls', 'middleware' => ['web', 'auth', 'XssProtection', 'checkAdmin']), function () {
    Route::prefix('polls')->group(function () {
        Route::match(['get', 'post'], 'list', [PollController::class, 'index'])->name('polls.list');
        Route::get('create', [PollController::class, 'create'])->name('polls.create');
        Route::post('store', [PollController::class, 'store'])->name('polls.store');
        Route::get('edit/{id}', [PollController::class, 'edit'])->name('polls.edit');
        Route::post('update', [PollController::class, 'update'])->name('polls.update');
    });
});

Route::post('pooling-action', [PollController::class, 'poolingAction'])->name('pooling_action');