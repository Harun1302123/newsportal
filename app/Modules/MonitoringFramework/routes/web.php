<?php

use App\Modules\MonitoringFramework\Http\Controllers\MefBankController;
use App\Modules\MonitoringFramework\Http\Controllers\MefCmisController;
use App\Modules\MonitoringFramework\Http\Controllers\MefCooperativesController;
use App\Modules\MonitoringFramework\Http\Controllers\MefIndicatorController;
use App\Modules\MonitoringFramework\Http\Controllers\MefInsuranceController;
use App\Modules\MonitoringFramework\Http\Controllers\MefMfisController;
use App\Modules\MonitoringFramework\Http\Controllers\MefMfsController;
use App\Modules\MonitoringFramework\Http\Controllers\MefNbfisController;
use App\Modules\MonitoringFramework\Http\Controllers\MefNsdController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::group(array('module' => 'MonitoringFramework', 'middleware' => ['web', 'auth', 'XssProtection', 'checkAdmin']), function () {

    Route::prefix('banks')->group(function () {
        Route::match(['get', 'post'], 'list', [MefBankController::class, 'index'])->name('banks.list');
        Route::get('create', [MefBankController::class, 'create'])->name('banks.create');
        Route::post('store', [MefBankController::class, 'store'])->name('banks.store');
        Route::get('edit/{id}', [MefBankController::class, 'edit'])->name('banks.edit');
        Route::get('view/{id}', [MefBankController::class, 'view'])->name('banks.view')->withoutMiddleware('checkAdmin');
        Route::get('summary-report', [MefBankController::class, 'summaryReport'])->name('banks.summary_report')->withoutMiddleware('checkAdmin');
        Route::get('summary-report-data', [MefBankController::class, 'summaryReportData'])->name('banks.summary_report_data')->withoutMiddleware('checkAdmin');
        Route::get('approve/{id}', [MefBankController::class, 'approve'])->name('banks.approve')->withoutMiddleware('checkAdmin');
        Route::get('check/{id}', [MefBankController::class, 'check'])->name('banks.check')->withoutMiddleware('checkAdmin');
        Route::get('shortfall/{id}', [MefBankController::class, 'shortfall'])->name('banks.shortfall')->withoutMiddleware('checkAdmin');
        Route::get('excel/{id}', [MefBankController::class, 'excel'])->name('banks.excel')->withoutMiddleware('checkAdmin');
        Route::get('excel-for-summary-data', [MefBankController::class, 'excelForSummaryData'])->name('banks.excel_for_summary_data')->withoutMiddleware('checkAdmin');
    });

    Route::prefix('nbfis')->group(function () {
        Route::match(['get', 'post'], 'list', [MefNbfisController::class, 'index'])->name('nbfis.list');
        Route::get('create', [MefNbfisController::class, 'create'])->name('nbfis.create');
        Route::post('store', [MefNbfisController::class, 'store'])->name('nbfis.store');
        Route::get('edit/{id}', [MefNbfisController::class, 'edit'])->name('nbfis.edit');
        Route::get('view/{id}', [MefNbfisController::class, 'view'])->name('nbfis.view')->withoutMiddleware('checkAdmin');
        Route::get('summary-report', [MefNbfisController::class, 'summaryReport'])->name('nbfis.summary_report')->withoutMiddleware('checkAdmin');
        Route::get('summary-report-data', [MefNbfisController::class, 'summaryReportData'])->name('nbfis.summary_report_data')->withoutMiddleware('checkAdmin');
        Route::get('approve/{id}', [MefNbfisController::class, 'approve'])->name('nbfis.approve')->withoutMiddleware('checkAdmin');
        Route::get('check/{id}', [MefNbfisController::class, 'check'])->name('nbfis.check')->withoutMiddleware('checkAdmin');
        Route::get('shortfall/{id}', [MefNbfisController::class, 'shortfall'])->name('nbfis.shortfall')->withoutMiddleware('checkAdmin');
        Route::get('excel/{id}', [MefNbfisController::class, 'excel'])->name('nbfis.excel')->withoutMiddleware('checkAdmin');
        Route::get('excel-for-summary-data', [MefNbfisController::class, 'excelForSummaryData'])->name('nbfis.excel_for_summary_data')->withoutMiddleware('checkAdmin');

    });

    Route::prefix('mfis')->group(function () {
        Route::match(['get', 'post'], 'list', [MefMfisController::class, 'index'])->name('mfis.list');
        Route::get('create', [MefMfisController::class, 'create'])->name('mfis.create');
        Route::post('store', [MefMfisController::class, 'store'])->name('mfis.store');
        Route::get('edit/{id}', [MefMfisController::class, 'edit'])->name('mfis.edit');
        Route::get('view/{id}', [MefMfisController::class, 'view'])->name('mfis.view')->withoutMiddleware('checkAdmin');
        Route::get('summary-report', [MefMfisController::class, 'summaryReport'])->name('mfis.summary_report')->withoutMiddleware('checkAdmin');
        Route::get('summary-report-data', [MefMfisController::class, 'summaryReportData'])->name('mfis.summary_report_data')->withoutMiddleware('checkAdmin');
        Route::get('approve/{id}', [MefMfisController::class, 'approve'])->name('mfis.approve')->withoutMiddleware('checkAdmin');
        Route::get('check/{id}', [MefMfisController::class, 'check'])->name('mfis.check')->withoutMiddleware('checkAdmin');
        Route::get('shortfall/{id}', [MefMfisController::class, 'shortfall'])->name('mfis.shortfall')->withoutMiddleware('checkAdmin');
        Route::get('excel/{id}', [MefMfisController::class, 'excel'])->name('mfis.excel')->withoutMiddleware('checkAdmin');
        Route::get('excel-for-summary-data', [MefMfisController::class, 'excelForSummaryData'])->name('mfis.excel_for_summary_data')->withoutMiddleware('checkAdmin');

    });

    Route::prefix('insurance')->group(function () {
        Route::match(['get', 'post'], 'list', [MefInsuranceController::class, 'index'])->name('insurance.list');
        Route::get('create', [MefInsuranceController::class, 'create'])->name('insurance.create');
        Route::post('store', [MefInsuranceController::class, 'store'])->name('insurance.store');
        Route::get('edit/{id}', [MefInsuranceController::class, 'edit'])->name('insurance.edit');
        Route::get('view/{id}', [MefInsuranceController::class, 'view'])->name('insurance.view')->withoutMiddleware('checkAdmin');
        Route::get('summary-report', [MefInsuranceController::class, 'summaryReport'])->name('insurance.summary_report')->withoutMiddleware('checkAdmin');
        Route::get('summary-report-data', [MefInsuranceController::class, 'summaryReportData'])->name('insurance.summary_report_data')->withoutMiddleware('checkAdmin');
        Route::get('approve/{id}', [MefInsuranceController::class, 'approve'])->name('insurance.approve')->withoutMiddleware('checkAdmin');
        Route::get('check/{id}', [MefInsuranceController::class, 'check'])->name('insurance.check')->withoutMiddleware('checkAdmin');
        Route::get('shortfall/{id}', [MefInsuranceController::class, 'shortfall'])->name('insurance.shortfall')->withoutMiddleware('checkAdmin');
        Route::get('excel/{id}', [MefInsuranceController::class, 'excel'])->name('insurance.excel')->withoutMiddleware('checkAdmin');
        Route::get('excel-for-summary-data', [MefInsuranceController::class, 'excelForSummaryData'])->name('insurance.excel_for_summary_data')->withoutMiddleware('checkAdmin');

    });

    Route::prefix('mfs')->group(function () {
        Route::match(['get', 'post'], 'list', [MefMfsController::class, 'index'])->name('mfs.list');
        Route::get('create', [MefMfsController::class, 'create'])->name('mfs.create');
        Route::post('store', [MefMfsController::class, 'store'])->name('mfs.store');
        Route::get('edit/{id}', [MefMfsController::class, 'edit'])->name('mfs.edit');
        Route::get('view/{id}', [MefMfsController::class, 'view'])->name('mfs.view')->withoutMiddleware('checkAdmin');
        Route::get('summary-report', [MefMfsController::class, 'summaryReport'])->name('mfs.summary_report')->withoutMiddleware('checkAdmin');
        Route::get('summary-report-data', [MefMfsController::class, 'summaryReportData'])->name('mfs.summary_report_data')->withoutMiddleware('checkAdmin');
        Route::get('approve/{id}', [MefMfsController::class, 'approve'])->name('mfs.approve')->withoutMiddleware('checkAdmin');
        Route::get('check/{id}', [MefMfsController::class, 'check'])->name('mfs.check')->withoutMiddleware('checkAdmin');
        Route::get('shortfall/{id}', [MefMfsController::class, 'shortfall'])->name('mfs.shortfall')->withoutMiddleware('checkAdmin');
        Route::get('excel/{id}', [MefMfsController::class, 'excel'])->name('mfs.excel')->withoutMiddleware('checkAdmin');
        Route::get('excel-for-summary-data', [MefMfsController::class, 'excelForSummaryData'])->name('mfs.excel_for_summary_data')->withoutMiddleware('checkAdmin');

    });

    Route::prefix('cooperatives')->group(function () {
        Route::match(['get', 'post'], 'list', [MefCooperativesController::class, 'index'])->name('cooperatives.list');
        Route::get('create', [MefCooperativesController::class, 'create'])->name('cooperatives.create');
        Route::post('store', [MefCooperativesController::class, 'store'])->name('cooperatives.store');
        Route::get('edit/{id}', [MefCooperativesController::class, 'edit'])->name('cooperatives.edit');
        Route::get('view/{id}', [MefCooperativesController::class, 'view'])->name('cooperatives.view')->withoutMiddleware('checkAdmin');
        Route::get('summary-report', [MefCooperativesController::class, 'summaryReport'])->name('cooperatives.summary_report')->withoutMiddleware('checkAdmin');
        Route::get('summary-report-data', [MefCooperativesController::class, 'summaryReportData'])->name('cooperatives.summary_report_data')->withoutMiddleware('checkAdmin');
        Route::get('approve/{id}', [MefCooperativesController::class, 'approve'])->name('cooperatives.approve')->withoutMiddleware('checkAdmin');
        Route::get('check/{id}', [MefCooperativesController::class, 'check'])->name('cooperatives.check')->withoutMiddleware('checkAdmin');
        Route::get('shortfall/{id}', [MefCooperativesController::class, 'shortfall'])->name('cooperatives.shortfall')->withoutMiddleware('checkAdmin');
        Route::get('excel/{id}', [MefCooperativesController::class, 'excel'])->name('cooperatives.excel')->withoutMiddleware('checkAdmin');
        Route::get('excel-for-summary-data', [MefCooperativesController::class, 'excelForSummaryData'])->name('cooperatives.excel_for_summary_data')->withoutMiddleware('checkAdmin');

    });

    Route::prefix('cmis')->group(function () {
        Route::match(['get', 'post'], 'list', [MefCmisController::class, 'index'])->name('cmis.list');
        Route::get('create', [MefCmisController::class, 'create'])->name('cmis.create');
        Route::post('store', [MefCmisController::class, 'store'])->name('cmis.store');
        Route::get('edit/{id}', [MefCmisController::class, 'edit'])->name('cmis.edit');
        Route::get('view/{id}', [MefCmisController::class, 'view'])->name('cmis.view')->withoutMiddleware('checkAdmin');
        Route::get('summary-report', [MefCmisController::class, 'summaryReport'])->name('cmis.summary_report')->withoutMiddleware('checkAdmin');
        Route::get('summary-report-data', [MefCmisController::class, 'summaryReportData'])->name('cmis.summary_report_data')->withoutMiddleware('checkAdmin');
        Route::get('approve/{id}', [MefCmisController::class, 'approve'])->name('cmis.approve')->withoutMiddleware('checkAdmin');
        Route::get('check/{id}', [MefCmisController::class, 'check'])->name('cmis.check')->withoutMiddleware('checkAdmin');
        Route::get('shortfall/{id}', [MefCmisController::class, 'shortfall'])->name('cmis.shortfall')->withoutMiddleware('checkAdmin');
        Route::get('excel/{id}', [MefCmisController::class, 'excel'])->name('cmis.excel')->withoutMiddleware('checkAdmin');
        Route::get('excel-for-summary-data', [MefCmisController::class, 'excelForSummaryData'])->name('cmis.excel_for_summary_data')->withoutMiddleware('checkAdmin');

    });

    Route::prefix('nsd')->group(function () {
        Route::match(['get', 'post'], 'list', [MefNsdController::class, 'index'])->name('nsd.list');
        Route::get('create', [MefNsdController::class, 'create'])->name('nsd.create');
        Route::post('store', [MefNsdController::class, 'store'])->name('nsd.store');
        Route::get('edit/{id}', [MefNsdController::class, 'edit'])->name('nsd.edit');
        Route::get('view/{id}', [MefNsdController::class, 'view'])->name('nsd.view')->withoutMiddleware('checkAdmin');
        Route::get('summary-report', [MefNsdController::class, 'summaryReport'])->name('nsd.summary_report')->withoutMiddleware('checkAdmin');
        Route::get('summary-report-data', [MefNsdController::class, 'summaryReportData'])->name('nsd.summary_report_data')->withoutMiddleware('checkAdmin');
        Route::get('approve/{id}', [MefNsdController::class, 'approve'])->name('nsd.approve')->withoutMiddleware('checkAdmin');
        Route::get('check/{id}', [MefNsdController::class, 'check'])->name('nsd.check')->withoutMiddleware('checkAdmin');
        Route::get('shortfall/{id}', [MefNsdController::class, 'shortfall'])->name('nsd.shortfall')->withoutMiddleware('checkAdmin');
        Route::get('excel/{id}', [MefNsdController::class, 'excel'])->name('nsd.excel')->withoutMiddleware('checkAdmin');
        Route::get('excel-for-summary-data', [MefNsdController::class, 'excelForSummaryData'])->name('nsd.excel_for_summary_data')->withoutMiddleware('checkAdmin');

    });

    Route::prefix('indicators')->group(function () {
        Route::match(['get', 'post'], 'list', [MefIndicatorController::class, 'index'])->name('indicators.list');
        Route::get('create', [MefIndicatorController::class, 'create'])->name('indicators.create');
        Route::post('store', [MefIndicatorController::class, 'store'])->name('indicators.store');
        Route::get('edit/{id}', [MefIndicatorController::class, 'edit'])->name('indicators.edit');
        Route::get('view/{id}', [MefIndicatorController::class, 'view'])->name('indicators.view')->withoutMiddleware('checkAdmin');
        Route::get('unpublish/{id}', [MefIndicatorController::class, 'unpublish'])->name('indicators.unpublish')->withoutMiddleware('checkAdmin');
        Route::get('published-indicator-data', [MefIndicatorController::class, 'publishedIndicatorData'])->name('indicators.published_indicator_data')->withoutMiddleware('checkAdmin');
        Route::get('summary-report', [MefIndicatorController::class, 'summaryReport'])->name('indicators.summary_report')->withoutMiddleware('checkAdmin');
        Route::get('indicator-total-score-form', [MefIndicatorController::class, 'indicatorTotalScoreForm'])->name('indicators.indicator_total_score_form')->withoutMiddleware('checkAdmin');
        Route::get('organization-wise-data-dashboard', [MefIndicatorController::class, 'organizationWiseDataDashboard'])->name('organization_wise_data_dashboard')->withoutMiddleware('checkAdmin');
        Route::get('integrated-index-score', [MefIndicatorController::class, 'integratedIndexScore'])->name('integrated_index_score')->withoutMiddleware('checkAdmin');
        Route::get('score-record-publish', [MefIndicatorController::class, 'scoreRecordPublish'])->name('score_record_publish')->withoutMiddleware('checkAdmin');
        Route::get('organization-info', [MefIndicatorController::class, 'organizationInfo'])->name('organization_info')->withoutMiddleware('checkAdmin');
        Route::get('shortfall-history', [MefIndicatorController::class, 'shortfallHistory'])->name('shortfall_history')->withoutMiddleware('checkAdmin');
    });

});

Route::get('set-wise-indicators-info', [MefIndicatorController::class, 'setWiseIndicatorsInfo'])->name('set_wise_indicators_info');
Route::get('portal-publish-score', [MefIndicatorController::class, 'portalPublishScore'])->name('portal_publish_score')->withoutMiddleware('checkAdmin');


Route::get('/run-artisan-command', function(){
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    return redirect()->back();
});

Route::group(array('prefix' => 'monitoring-framework', 'middleware' => ['web', 'auth', 'XssProtection']), function () {
    Route::group(['prefix' => 'common-api/v1/'], function () {

    });
});
