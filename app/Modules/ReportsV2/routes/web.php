<?php

use Illuminate\Support\Facades\Route;


Route::group(['module' => 'ReportsV2', 'middleware' => ['web', 'auth', 'XssProtection', 'GlobalSecurity']], function () {

    Route::get('/reportv2/list', "ReportsControllerV2@index")->name('reportv2.list');

    Route::get('/reportv2/create', "ReportsControllerV2@create");
    Route::get('/reportv2/edit/{id}', "ReportsControllerV2@edit");

    Route::get('/reportv2/show/{id}', "@show");
    Route::get('/reportv2/view/{id}', "ReportsControllerV2@view");
    Route::get('/reportv2/getuserbytype', "ReportsControllerV2@getusers");

    Route::get('/reportv2/add-to-favourite/{id}', "ReportsControllerV2@addToFavourite");
    Route::get('/reportv2/remove-from-favourite/{id}', "ReportsControllerV2@removeFavourite");

    Route::post('/reportv2/add-remove-favourite-ajax', "ReportsControllerV2@addRemoveFavouriteAjax");

    Route::post('/reportv2/verify', "ReportsControllerV2@reportsVerify");
    Route::get('/reportv2/tables', "ReportsControllerV2@showTables");
    Route::get('/reportv2/get-report-category', "ReportsControllerV2@getReportCategory");

    Route::post('/reportv2/show-report/{report_id}', "ReportsControllerV2@showReport");
    Route::get('/reportv2/show-report/{report_id}', "ReportsControllerV2@showReport");

    foreach (glob(__DIR__ . '/routes/*.php') as $route_file) {
        require $route_file;
    }

    Route::patch('/reportv2/store', "ReportsControllerV2@store");
    Route::patch('/reportv2/update/{id}', "ReportsControllerV2@update");
});
