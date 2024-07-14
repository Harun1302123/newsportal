<?php

use Illuminate\Support\Facades\Route;



Route::group(['module' => 'API'], function () {

    //ob#code@start - (arif) -
    // 01. use match for responds to multiple HTTP verbs
    // 02. calling from where this route need details information
        // if no need this method then remove the relevant code

    //Route::match(['get', 'post'], 'osspid/api', 'APIController@apiRequest');

    Route::get('osspid/api', 'APIController@apiRequest');
    Route::post('osspid/api', 'APIController@apiRequest');
    //ob#code@end - (arif)

     //ob#code@start - (arif) - AppsWebController & QRLoginController controller not found
    Route::get('web/view-mis-reports/{report_id}/{permission_id}/{unix_time}', "AppsWebController@misReportView");
    Route::get('web/search/{enc_reg_key}/{keyword}', "AppsWebController@appSearch");
    Route::get('web/view-image/{enc_user_id}', "AppsWebController@viewImage");
    Route::get('/server-info', 'AppsWebController@serverInfo');

    Route::get('/qr-code/show', 'QRLoginController@showQrCode');
    Route::get('/qr-login-check', 'QRLoginController@qrLoginCheck');
    Route::get('/qr-log-out', 'QRLoginController@qrLogout');
    //ob#code@end - (arif)


    // Action info store API
    Route::post('/api/new-job', 'APIController@newJob');
    Route::post('/api/action/new-job', 'APIController@actionNewJob');


});
