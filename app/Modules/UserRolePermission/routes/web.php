<?php

use App\Modules\UserRolePermission\Http\Controllers\UserRolePermissionController;
use Illuminate\Support\Facades\Route;

Route::group(array('module' => 'UserRolePermission', 'middleware' => ['auth','web', 'XssProtection', 'checkAdmin']), function () {
    Route::prefix('user-role-permission')->group(function () {
        Route::match(['get', 'post'], 'list', [UserRolePermissionController::class, 'index'])->name('user-role-permission.list');
        Route::get('create/{id}', [UserRolePermissionController::class, 'assignPermission'])->name('user-role-permission.create');
        Route::post('store', [UserRolePermissionController::class, 'store'])->name('user-role-permission.store');
    });
});
