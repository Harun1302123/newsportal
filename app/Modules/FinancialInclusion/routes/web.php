<?php

use Illuminate\Support\Facades\Route;
use App\Modules\FinancialInclusion\Http\Controllers\FinancialInclusionController;

Route::group(array('module' => 'FinancialInclusion', 'middleware' => ['web', 'auth','XssProtection', 'checkAdmin']), function () {
    Route::prefix('financial_inclusions')->group(function () {
        Route::match(['get', 'post'], 'list', [FinancialInclusionController::class, 'index'])->name('financial_inclusions.list');
        Route::get('create', [FinancialInclusionController::class, 'create'])->name('financial_inclusions.create');
        Route::post('store', [FinancialInclusionController::class, 'store'])->name('financial_inclusions.store');
        Route::get('edit/{id}', [FinancialInclusionController::class, 'edit'])->name('financial_inclusions.edit');
        Route::get('view/{id}', [FinancialInclusionController::class, 'view'])->name('financial_inclusions.view');
    });
});
