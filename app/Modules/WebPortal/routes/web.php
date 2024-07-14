<?php

use App\Modules\WebPortal\Http\Controllers\BannerController;
use App\Modules\WebPortal\Http\Controllers\AchievementController;
use App\Modules\WebPortal\Http\Controllers\CreditController;
use App\Modules\WebPortal\Http\Controllers\ImportantLinkController;
use App\Modules\WebPortal\Http\Controllers\BiographyController;
use App\Modules\WebPortal\Http\Controllers\EventController;
use App\Modules\WebPortal\Http\Controllers\NationalStrategiesNFISController;
use App\Modules\WebPortal\Http\Controllers\PublicationController;
use App\Modules\WebPortal\Http\Controllers\ResourceController;
use App\Modules\WebPortal\Http\Controllers\NewsController;
use App\Modules\WebPortal\Http\Controllers\RulesRegulationsController;
use App\Modules\WebPortal\Http\Controllers\VideoGalleryController;
use App\Modules\WebPortal\Http\Controllers\PhotoGalleryController;
use App\Modules\WebPortal\Http\Controllers\MenuItemController;
use App\Modules\WebPortal\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Modules\WebPortal\Http\Controllers\NoticeController;
use App\Modules\WebPortal\Http\Controllers\HomePageCategoryController;


Route::group(array('module' => 'WebPortal', 'middleware' => ['web', 'auth', 'XssProtection', 'checkAdmin']), function () {

    Route::prefix('banners')->group(function () {
        Route::match(['get', 'post'], 'list', [BannerController::class, 'index'])->name('banners.list');
        Route::get('create', [BannerController::class, 'create'])->name('banners.create');
        Route::post('store', [BannerController::class, 'store'])->name('banners.store');
        Route::get('edit/{id}', [BannerController::class, 'edit'])->name('banners.edit');
    });

    Route::prefix('biographies')->group(function () {
        Route::match(['get', 'post'], 'list', [BiographyController::class, 'index'])->name('biographies.list');
        Route::get('create', [BiographyController::class, 'create'])->name('biographies.create');
        Route::get('edit/{id}', [BiographyController::class, 'edit'])->name('biographies.edit');
    });

    // articles will be news
    Route::prefix('news')->group(function () {
        Route::match(['get', 'post'], 'list', [NewsController::class, 'index'])->name('news.list');
        Route::get('create', [NewsController::class, 'create'])->name('news.create');
        Route::get('edit/{id}', [NewsController::class, 'edit'])->name('news.edit');
    });

    Route::prefix('events')->group(function () {
        Route::match(['get', 'post'], 'list', [EventController::class, 'index'])->name('events.list');
        Route::get('create', [EventController::class, 'create'])->name('events.create');
        Route::post('store', [EventController::class, 'store'])->name('events.store');
        Route::get('edit/{id}', [EventController::class, 'edit'])->name('events.edit');
    });

    Route::prefix('video-galleries')->group(function () {
        Route::match(['get', 'post'], 'list', [VideoGalleryController::class, 'index'])->name('video-galleries.list');
        Route::get('create', [VideoGalleryController::class, 'create'])->name('video-galleries.create');
        Route::post('store', [VideoGalleryController::class, 'store'])->name('video-galleries.store');
        Route::get('edit/{id}', [VideoGalleryController::class, 'edit'])->name('video-galleries.edit');
    });

    Route::prefix('photo-galleries')->group(function () {
        Route::match(['get', 'post'], 'list', [PhotoGalleryController::class, 'index'])->name('photo-galleries.list');
        Route::get('create', [PhotoGalleryController::class, 'create'])->name('photo-galleries.create');
        Route::post('store', [PhotoGalleryController::class, 'store'])->name('photo-galleries.store');
        Route::get('edit/{id}', [PhotoGalleryController::class, 'edit'])->name('photo-galleries.edit');
    });

    Route::prefix('resources')->group(function () {
        Route::match(['get', 'post'], 'list', [ResourceController::class, 'index'])->name('resources.list');
        Route::get('create', [ResourceController::class, 'create'])->name('resources.create');
        Route::post('store', [ResourceController::class, 'store'])->name('resources.store');
        Route::get('edit/{id}', [ResourceController::class, 'edit'])->name('resources.edit');
    });


    Route::prefix('important-links')->group(function () {
        Route::match(['get', 'post'], 'list', [ImportantLinkController::class, 'index'])->name('important-links.list');
        Route::get('create', [ImportantLinkController::class, 'create'])->name('important-links.create');
        Route::post('store', [ImportantLinkController::class, 'store'])->name('important-links.store');
        Route::get('edit/{id}', [ImportantLinkController::class, 'edit'])->name('important-links.edit');
        Route::post('update', [ImportantLinkController::class, 'update'])->name('important-links.update');
    });

    Route::prefix('achievements')->group(function () {
        Route::match(['get', 'post'], 'list', [AchievementController::class, 'index'])->name('achievements.list');
        Route::get('create', [AchievementController::class, 'create'])->name('achievements.create');
        Route::post('store', [AchievementController::class, 'store'])->name('achievements.store');
        Route::get('edit/{id}', [AchievementController::class, 'edit'])->name('achievements.edit');
        Route::post('update', [AchievementController::class, 'update'])->name('achievements.update');
    });

    Route::prefix('notices')->group(function () {
        Route::match(['get', 'post'], 'list', [NoticeController::class, 'index'])->name('notices.list');
        Route::get('create', [NoticeController::class, 'create'])->name('notices.create');
        Route::post('store', [NoticeController::class, 'store'])->name('notices.store');
        Route::get('edit/{id}', [NoticeController::class, 'edit'])->name('notices.edit');
    });

    Route::prefix('menu-items')->group(function () {
        Route::match(['get', 'post'], 'list', [MenuItemController::class, 'index'])->name('menu-items.list');
        Route::get('create', [MenuItemController::class, 'create'])->name('menu-items.create');
        Route::get('edit/{id}', [MenuItemController::class, 'edit'])->name('menu-items.edit');
    });

    Route::prefix('comments')->group(function () {
        Route::match(['get', 'post'], 'list', [CommentController::class, 'index'])->name('comments.list');
    });

    Route::prefix('homepage-categories')->group(function () {
        Route::match(['get', 'post'], 'list', [HomePageCategoryController::class, 'index'])->name('homepage.categories.list');
        Route::get('create', [HomePageCategoryController::class, 'create'])->name('homepage.categories.create');
        Route::post('store', [HomePageCategoryController::class, 'store'])->name('homepage.categories.store');
        Route::get('edit/{id}', [HomePageCategoryController::class, 'edit'])->name('homepage.categories.edit');
    });

    Route::prefix('credits')->group(function () {
        Route::match(['get', 'post'], 'list', [CreditController::class, 'index'])->name('credits.list');
        Route::get('create', [CreditController::class, 'create'])->name('credits.create');
        Route::post('store', [CreditController::class, 'store'])->name('credits.store');
        Route::get('edit/{id}', [CreditController::class, 'edit'])->name('credits.edit');
    });

    Route::prefix('publications')->group(function () {
        Route::match(['get', 'post'], 'list', [PublicationController::class, 'index'])->name('publications.list');
        Route::get('create', [PublicationController::class, 'create'])->name('publications.create');
        Route::post('store', [PublicationController::class, 'store'])->name('publications.store');
        Route::get('edit/{id}', [PublicationController::class, 'edit'])->name('publications.edit');
    });

    Route::prefix('national-strategies-nfis')->group(function () {
        Route::match(['get', 'post'], 'list', [NationalStrategiesNFISController::class, 'index'])->name('national_strategies_nfis.list');
        Route::get('create', [NationalStrategiesNFISController::class, 'create'])->name('national_strategies_nfis.create');
        Route::post('store', [NationalStrategiesNFISController::class, 'store'])->name('national_strategies_nfis.store');
        Route::get('edit/{id}', [NationalStrategiesNFISController::class, 'edit'])->name('national_strategies_nfis.edit');
    });

    Route::prefix('rules-regulations')->group(function () {
        Route::match(['get', 'post'], 'list', [RulesRegulationsController::class, 'index'])->name('rules_regulations.list');
        Route::get('create', [RulesRegulationsController::class, 'create'])->name('rules_regulations.create');
        Route::post('store', [RulesRegulationsController::class, 'store'])->name('rules_regulations.store');
        Route::get('edit/{id}', [RulesRegulationsController::class, 'edit'])->name('rules_regulations.edit');
    });
});


Route::group(array('module' => 'WebPortal', 'middleware' => ['web', 'auth','XssProtection', 'checkAdmin']), function () {

    Route::prefix('menu-items')->group(function () {
        Route::post('store', [MenuItemController::class, 'store'])->name('menu-items.store');
    });

    Route::prefix('biographies')->group(function () {
        Route::post('store', [BiographyController::class, 'store'])->name('biographies.store');
    });

    Route::prefix('news')->group(function () {
        Route::post('store', [NewsController::class, 'store'])->name('news.store');
    });

    Route::prefix('events')->group(function () {
        Route::post('store', [EventController::class, 'store'])->name('events.store');
    });
});
