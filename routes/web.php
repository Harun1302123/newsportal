<?php

use App\Http\Controllers\Frontend\MandEFrameworkController;
use App\Http\Controllers\Frontend\PublicationController;
use App\Http\Controllers\Frontend\SdgNfisController;
use App\Http\Controllers\Frontend\StakeholderController;
use App\Http\Controllers\Frontend\SteeringCommitteeController;
use App\Http\Controllers\Frontend\StrategicGoalsController;
use App\Http\Controllers\Frontend\VideoGalleryController;
use App\Http\Controllers\Frontend\PhotoGalleryController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Frontend\FinancialInclusionAtAGlanceController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\EventsController;
use App\Http\Controllers\Frontend\FaqController;
use App\Modules\SignUp\Http\Controllers\SignUpController;
use Illuminate\Support\Facades\Session;

Route::get('/', [HomePageController::class, 'home'])->name('frontend.home');

Route::get('poll-details', [HomePageController::class, 'pollDetails'])->name('poll_details');
Route::get('important-link', [HomePageController::class, 'ImportantLink'])->name('important_link');
Route::get('resources', [HomePageController::class, 'Resource'])->name('frontend.resource');

Route::group(array('middleware' => ['web', 'XssProtection']), function () {
    Route::get('comments', [HomePageController::class, 'comments'])->name('frontend.comments');
    Route::post('comments', [HomePageController::class, 'commentStore'])->name('frontend.comments.store');
});
Route::get('contact-us', [HomePageController::class, 'contactUs'])->name('frontend.contact.us');
Route::post('get-search-results', [HomePageController::class, 'globalSearch']);

Route::get('menu/{slug}', [HomePageController::class, 'dynamicMenuShow'])->name('dynamicMenuShow');
Route::get('strategic-goals', [StrategicGoalsController::class, 'index'])->name('frontend.strategicGoals');
Route::get('stakeholders', [StakeholderController::class, 'index'])->name('frontend.stakeholders');
Route::get('steering-committee', [SteeringCommitteeController::class, 'index'])->name('frontend.steeringCommittee');
Route::get('sdg-nfis', [SdgNfisController::class, 'index'])->name('frontend.sdgNfis');
Route::get('m-and-e-framework', [MandEFrameworkController::class, 'index'])->name('frontend.mAndeFramework');
Route::get('details', [MandEFrameworkController::class, 'details'])->name('frontend.details');

Route::get('financial-inclusion-at-a-glance', [FinancialInclusionAtAGlanceController::class, 'index'])->name('frontend.financialInclusionAtAGlance');
Route::post('financial-inclusion-at-a-glance/details', [FinancialInclusionAtAGlanceController::class, 'details'])->name('frontend.financialInclusionAtAGlance.details');

Route::get('video-galleries', [VideoGalleryController::class, 'index'])->name('frontend.videoGalleries.list');
Route::post('get-video-by-category', [VideoGalleryController::class, 'getVideoByCategory'])->name('video.by.category');

Route::get('biography-details/{id}', [HomePageController::class, 'BiographyDetail'])->name('frontend.biography.detail');

Route::get('photo-galleries', [PhotoGalleryController::class, 'index'])->name('frontend.photoGalleries.list');
Route::post('get-photo-by-category', [PhotoGalleryController::class, 'getPhotoByCategory'])->name('photo.by.category');
Route::get('photo-galleries/{id}', [PhotoGalleryController::class, 'show'])->name('frontend.photoGalleries.show');

Route::get('news', [NewsController::class, 'index'])->name('frontend.news.list');
Route::get('news/{id}', [NewsController::class, 'show'])->name('frontend.news.show');

Route::get('events', [EventsController::class, 'index'])->name('frontend.event.list');
Route::get('events/{id}', [EventsController::class, 'show'])->name('frontend.event.show');

Route::get('faq/',[FaqController::class, 'index'])->name('frontend.faq.list');

Route::get('forget-password', [LoginController::class, 'forgetPassword'])->name('forget_password');

Route::get('login', [LoginController::class, 'systemLogin'])->name('login');
Route::post('login/check', [LoginController::class, 'check']);

Route::get('signup', [SignUpController::class, 'signup'])->name('signup');
Route::post('signup-store', [SignUpController::class, 'storeSignup'])->name('signup.store');

Route::get('citizen-charter', [HomePageController::class, 'citizenCharter'])->name('citizen.charter');
Route::get('sitemap', [HomePageController::class, 'sitemap'])->name('sitemap');

Route::get('credit-list', [HomePageController::class, 'credit'])->name('frontend.credit');

Route::get('publication', [PublicationController::class, 'index'])->name('frontend.publication.list');
Route::get('publication/{id}', [PublicationController::class, 'show'])->name('frontend.publication.show');
Route::post('get-publication-by-category/', [PublicationController::class, 'getPublicationByCategory'])->name('publication.by.category');

Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    sleep(1);
    return redirect()->back();
});

Route::get('/run-command', function(){
    Artisan::call('send:email');
    Artisan::call('send:sms');
});


