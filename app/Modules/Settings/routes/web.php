<?php


use Illuminate\Support\Facades\Route;

Route::group(array('module' => 'Settings', 'middleware' => ['web', 'auth','XssProtection', 'checkAdmin']), function () {
    Route::get('contact-setting/list', "ContactSettingController@index");
    Route::get('/contact-setting/edit', 'ContactSettingController@edit');
    Route::post('contact-setting/update', "ContactSettingController@update");
});

Route::group(array('module' => 'Settings', 'middleware' => ['web', 'auth']), function () {

    Route::get('/settings/get-district-by-division-id', 'SettingsController@get_district_by_division_id');
    Route::get('settings/get-police-stations', 'SettingsController@getPoliceStations');
    Route::get('settings/get-district-user', 'SettingsController@getDistrictUser');
});

/* *************************************************
 * All routes for Common OSS Feature
 * Please, Do not write project basis routes here.
 ************************************************* */
Route::group(array('module' => 'Settings', 'middleware' => ['web', 'auth']), function () {

    //****** Maintenance Mode  ****//
    Route::get('settings/maintenance-mode', "SettingsController@maintenanceMode");
    Route::get('settings/maintenance-mode/get-users-list', "SettingsController@getMaintenanceUserList");
    Route::get('settings/maintenance-mode/remove-user/{user_id}', "SettingsController@removeUserFromMaintenance");
    Route::post('settings/maintenance-mode/store', "SettingsController@maintenanceModeStore");

    //*********** Display Device ******************//
    Route::get('settings/display-settings/display-device', 'DisplaySettingsController@displayDeviceList');
    Route::get('settings/display-settings/get-display-device-data', 'DisplaySettingsController@getDisplayDeviceData');
    Route::get('settings/display-settings/create-display-device', 'DisplaySettingsController@createNewDisplayDevice');
    Route::post('settings/display-settings/store-display-device', 'DisplaySettingsController@storeDisplayDevice');
    Route::get('settings/display-settings/edit-display-device/{id}', 'DisplaySettingsController@editDisplayDevice');
    Route::patch('settings/display-settings/update-display-device/{id}', 'DisplaySettingsController@updateDisplayDevice');
    Route::get('settings/display-settings/show-request-history/{id}', 'DisplaySettingsController@showRequestHistoryDevice');

    //*********** Server Info ******************//
    Route::get('settings/server-info', 'ServerInfoController@serverInfo');
});

Route::group(array('module' => 'Settings', 'middleware' => ['web', 'auth']), function () {

    //****** Notice List ****//
    Route::get('settings/notice-list', "SettingsControllerV2@NoticeList");
    Route::post('settings/store-notice', "SettingsControllerV2@storeNotice");
    Route::get('settings/edit-notice/{id}', "SettingsControllerV2@editNotice");
    Route::post('settings/update-notice/{id}', "SettingsControllerV2@updateNotice");

    //****** Act & Rules List ****//

    Route::get('settings/act-rules-list', "SettingsControllerV2@ActRulesList");
    Route::post('settings/store-act-rules', "SettingsControllerV2@StoreActRules");
    Route::get('settings/edit-act-rules/{id}', "SettingsControllerV2@editActRules");
    //    Route::patch('settings/update-act-rules/{id}', "SettingsControllerV2@updateActRules");
    Route::post('settings/update-act-rules', "SettingsControllerV2@updateActRules");


    //****** Area List ****//
    Route::get('settings/get-division-name', "SettingsControllerV2@divisionName");
    Route::get('settings/get-thana-by-district-id', 'SettingsControllerV2@get_thana_by_district_id');
    Route::get('settings/get-district', 'SettingsControllerV2@getDistrict');
    Route::get('settings/area-list', "SettingsControllerV2@AreaList");
    Route::post('settings/store-area', "SettingsControllerV2@StoreArea");
    Route::get('settings/edit-area/{id}', "SettingsControllerV2@editArea");
    Route::patch('settings/update-area/{id}', "SettingsControllerV2@updateArea");


    //****** user type List ****//
    Route::get('settings/user-type-list', "SettingsControllerV2@userTypeList");
    Route::get('settings/edit-user-type/{id}', "SettingsControllerV2@editUserType");
    Route::get('settings/get-security-list', "SettingsControllerV2@getSecurityList");
    Route::patch('settings/update-user-type/{id}', "SettingsControllerV2@updateUserType");


    //****** user-manual List ****//
    Route::get('settings/user-manual', "SettingsControllerV2@UserManualList");
    Route::post('settings/home-page/store-user-manual', "SettingsControllerV2@UsermanualStore");
    Route::get('settings/home-page/edit-user-manual/{id}', "SettingsControllerV2@editUsermanual");
    Route::post('settings/home-page/update-user-manual', "SettingsControllerV2@updateUsermanual");

    //****** home-page-content List ****//
    Route::get('settings/home-page/home-page-content', "SettingsControllerV2@homeContentList");
    Route::post('settings/home-page/store-home-page-content', "SettingsControllerV2@homeContentStore");
    Route::get('settings/home-page/edit-home-page-content/{id}', "SettingsControllerV2@edithomeContent");
    Route::post('settings/home-page/update-home-page-content', "SettingsControllerV2@updatehomeContent");

    //****** home-page-articles ****//
    Route::get('settings/home-page/home-page-articles', "SettingsControllerV2@homeArticlesList");
    Route::post('settings/home-page/store-home-page-articles', "SettingsControllerV2@homeArticlesStore");
    Route::get('settings/home-page/edit-home-page-articles/{id}', "SettingsControllerV2@edithomeArticles");
    Route::post('settings/home-page/update-home-page-articles', "SettingsControllerV2@updatehomeArticles");

    //****** industrial advisor ****//
    Route::get('settings/home-page/industrial-advisor', "IndustrialAdvisorController@IndustrialAdvisorList");
    Route::post('settings/home-page/store-industrial-advisor', "IndustrialAdvisorController@IndustrialAdvisorStore");
    Route::get('settings/home-page/edit-industrial-advisor/{id}', "IndustrialAdvisorController@editIndustrialAdvisor");
    Route::post('settings/home-page/update-industrial-advisor', "IndustrialAdvisorController@updateIndustrialAdvisor");

    //****** home-page-slider List ****//
    Route::get('settings/home-page/home-page-slider-list', "SettingsControllerV2@HomePageSliderList");
    Route::post('settings/home-page/store-home-page-slider', "SettingsControllerV2@homePageSliderStore");
    Route::get('settings/home-page/edit-home-page-slider/{id}', "SettingsControllerV2@editHomePageSlider");
    Route::post('settings/home-page/update-home-page-slider', "SettingsControllerV2@updateHomePageSlider");


    //****** Email-SMS-Query List ****//
    Route::get('settings/email-sms-queue', 'SettingsControllerV2@emailSmsQueueList');
    Route::get('settings/email-sms-queue-edit/{id}', 'SettingsControllerV2@editEmailSmsQueue');
    Route::patch('settings/update-email-sms-queue/{id}', "SettingsControllerV2@updateEmailSmsQueue");
    Route::get('settings/resend-email-sms-queue/{id}/{type}', 'SettingsControllerV2@resendEmailSmsQueue');

    //****** Security List ****//
    Route::get('settings/security', "SettingsControllerV2@SecurityList");
    Route::post('settings/store-security', "SettingsControllerV2@storeSecurity");
    Route::get('settings/edit-security/{id}', "SettingsControllerV2@editSecurity");
    Route::post('settings/update-security/{id}', "SettingsControllerV2@updateSecurity");


    //****** Logo List ****//
    Route::post('settings/update-logo', "SettingsControllerV2@storeLogo");
    Route::get('settings/logo-edit', "SettingsControllerV2@editLogo");

    //****** Soft Delete ****//
    Route::get('settings/delete/{model}/{id}', "SettingsControllerV2@softDelete");

    // Route to handle page reload in Vue except for api routes
    Route::get('settings/{index?}', 'SettingsControllerV2@index')->where('index', '(.*)');
    //    Route::get('settings/{index?}', 'SettingsControllerV2@branch')->where('index', '(.*)');

//    Route::get('achievements/list', "AchievementController@index");
//    Route::resource('achievements', 'AchievementController');
});
