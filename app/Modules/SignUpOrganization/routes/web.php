<?php

use App\Modules\SignUpOrganization\Http\Controllers\SignUpOrganizationController;
use Illuminate\Support\Facades\Route;

Route::group(array('module' => 'SignUp Organizations', 'middleware' => ['web', 'auth', 'XssProtection', 'checkAdmin']), function () {
    Route::prefix('signup-organizations')->group(function () {

        Route::match(['get', 'post'], 'list', [SignUpOrganizationController::class, 'index'])->name('signup-organizations.list');
        Route::get('create', [SignUpOrganizationController::class, 'create'])->name('signup-organizations.create');
        Route::post('store', [SignUpOrganizationController::class, 'store'])->name('signup-organizations.store');
        Route::get('edit/{id}', [SignUpOrganizationController::class, 'edit'])->name('signup-organizations.edit');
        Route::post('update', [SignUpOrganizationController::class, 'update'])->name('signup-organizations.update');
    });

});