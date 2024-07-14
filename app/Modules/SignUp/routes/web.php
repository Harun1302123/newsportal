<?php

use App\Modules\SignUp\Http\Controllers\SignUpController;
use Illuminate\Support\Facades\Route;

Route::group(array('module' => 'SignUp', 'middleware' => ['web', 'auth', 'XssProtection', 'checkAdmin']), function () {

    Route::prefix('signup-users')->group(function () {
        Route::match(['get', 'post'], 'list', [SignUpController::class, 'index'])->name('signup.list');
//        Route::get('create', [SignUpController::class, 'create'])->name('signup.create');
//        Route::post('store', [SignUpController::class, 'store'])->name('signup.store');
//        Route::get('edit/{id}', [SignUpController::class, 'edit'])->name('signup.edit');
        Route::get('view/{id}', [SignUpController::class, 'view'])->name('signup.view');
        Route::get('create-user/{id}', [SignUpController::class, 'storeNewUser'])->name('signup.create_user')->withoutMiddleware('checkAdmin');
        Route::get('reject-user/{id}', [SignUpController::class, 'rejectUser'])->name('signup.reject_user')->withoutMiddleware('checkAdmin');

    });
    Route::post('get-organigation-name', [SignUpController::class, 'getOrganigationName'])->name('get_organigation_name')->withoutMiddleware(['auth','checkAdmin']);
    Route::post('check-userid', [SignUpController::class, 'checkUserId'])->name('check_userid')->withoutMiddleware(['auth','checkAdmin']);

});




