<?php

use Illuminate\Support\Facades\Route;
use App\Modules\FAQ\Http\Controllers\FAQController;


Route::group(array('module' => 'FAQ', 'middleware' => ['web', 'auth', 'XssProtection', 'checkAdmin']), function () {
    Route::prefix('faq')->group(function () {
        Route::match(['get', 'post'], 'list', [FAQController::class, 'index'])->name('faq.list');
        Route::get('create', [FAQController::class, 'create'])->name('faq.create');
        Route::post('store', [FAQController::class, 'store'])->name('faq.store');
        Route::get('edit/{id}', [FAQController::class, 'edit'])->name('faq.edit');
    });
});
