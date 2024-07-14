<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Communication\Http\Controllers\CommunicationController;

Route::group(array('module' => 'Communication', 'middleware' => ['web', 'auth','XssProtection', 'checkAdmin']), function () {
    Route::prefix('communications')->group(function () {
        Route::match(['get', 'post'], 'list', [CommunicationController::class, 'index'])->name('communications.list');
        Route::get('create', [CommunicationController::class, 'create'])->name('communications.create');
        Route::post('store', [CommunicationController::class, 'store'])->name('communications.store');
        Route::get('edit/{id}', [CommunicationController::class, 'edit'])->name('communications.edit');
        Route::get('view/{id}', [CommunicationController::class, 'view'])->name('communications.view');
    });

});

Route::group(array('module' => 'Communication', 'middleware' => ['web','XssProtection', 'auth']), function () {
    Route::prefix('communications')->group(function (){
        Route::post('organization_type_wise_organizations', [CommunicationController::class, 'organizationTypeWiseOrganizations'])->name('organization_type_wise_organizations');
    });
});
