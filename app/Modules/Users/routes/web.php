<?php

use App\Modules\Users\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::group(array('module' => 'Users', 'middleware' => ['web', 'auth', 'GlobalSecurity', 'XssProtection', 'checkAdmin']), function () {
    /* User related */
    Route::get('/users/list', "UsersController@lists");
    Route::post('users/get-users-list', "UsersController@getList");
    Route::get('/users/create', ['as' => 'user_create_url', 'uses' => 'UsersController@create']);
    Route::get('users/view/{id}', [UsersController::class,'view']);
    Route::post('/users/update/{id}', "UsersController@update");
    Route::get('/users/edit/{id}', "UsersController@edit");
});

// Only Login User can do it.
Route::group(array('module' => 'Users', 'middleware' => ['web', 'auth', 'GlobalSecurity', 'XssProtection']), function () {
    Route::post('users/get-ministry_division_by_ministry_id', "UsersController@getMinistryDivisionByMinistryId");
    Route::post('/users/get-ministry_department_by_min_divi_id', "UsersController@getMinistryDepartmentByMinDivisionId");
    Route::post('/users/get-ministry_office_by_min_department_id', "UsersController@getOfficeByMinDeptId");
    Route::post('/users/get-designaton_by_office_id', "UsersController@getMinistryDesignationByMinOfficeId");

    Route::get('/users/activate/{id}', [UsersController::class,'activate']);

    /* New User Creation by Admin */
    Route::get('/users/force-logout/{id}', 'UsersController@forceLogout');
    Route::get('users/create-new-user', "UsersController@createNewUser");
    Route::patch('/users/store-new-user', "UsersController@storeNewUser");
    Route::get('users/check-unique-username', "UsersController@checkUniqueUsername");
    /* End of New User Creation by Admin */

    /* User profile update */
    Route::get('users/profileinfo', [UsersController::class, 'profileInfo']);
    Route::post('users/profile_updates/{id}', ['uses' => 'UsersController@profile_update']);
    Route::patch('users/update-password-from-profile', "UsersController@updatePassFromProfile");

    /* User related */
    Route::post('users/get-access-log-data-for-self', "UsersController@getAccessLogDataSelf");
    Route::post('users/get-access-log-failed', "UsersController@getFailedLoginData");
    Route::post('users/get-last-50-actions', "UsersController@getLast50Actions");
    Route::get('users/access-log/{id}', "UsersController@accessLogHist");
    Route::get('users/get-access-log-data', "UsersController@accessLogHist");
    Route::get('/users/logout', "UsersController@logout");
    Route::get('users/failedLogin-history/{id}', "UsersController@failedLoginHist");
    Route::post('users/failed-login-data-resolved', "UsersController@FailedDataResolved");


    /* Reset Password from profile and Admin list */
    Route::get('users/reset-password/{confirmationCode}', ['as' => 'resetPassword', 'uses' => 'UsersController@resetPassword']);
    Route::post('users/get-access-log-data/{id}', "UsersController@getAccessLogData");
});

// Without Authorization (Login is not required)

Route::group(array('module' => 'Users', 'middleware' => ['web']), function () {
    Route::get('users/verification/{confirmationCode}', ['as' => 'confirmationPath', 'uses' => 'UsersController@verification']);

    // verification
    Route::get('/users/verify-created-user/{encrypted_token}', "UsersController@verifyCreatedUser");
    Route::patch('/users/created-user-verification/{encrypted_token}', "UsersController@createdUserVerification");
    Route::patch('users/verification_store/{confirmationCode}', ['as' => 'verificationStore', 'uses' => 'UsersController@verification_store']);

    //Mail Re-sending
    Route::get('users/reSendEmail', "UsersController@reSendEmail");
    Route::patch('users/reSendEmailConfirm', "UsersController@reSendEmailConfirm");
    Route::post('/users/validateAutoCompleteData/{type}', 'UsersController@validateAutoCompleteData');
    Route::get('users/get-user-session', 'UsersController@getUserSession');
    Route::post('users/resend-email-verification', "UsersController@resendVerification");
    Route::get('users/resend-email-verification-from-admin/{enc_user_id}', "UsersController@resendVerificationFromAdmin");
});

Route::group(array('module' => 'Users', 'middleware' => ['web', 'auth','XssProtection']), function () {
    /* To step Verification */
    Route::get('/users/two-step', [UsersController::class, 'twoStep']);
    Route::patch('/users/check-two-step', [UsersController::class, 'checkTwoStep']);
    Route::patch('/users/verify-two-step', [UsersController::class, 'verifyTwoStep']);
});

