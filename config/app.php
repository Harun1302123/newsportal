<?php

use Illuminate\Support\Facades\Facade;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', "NFIS Tracker | Bangladesh's Financial Mirror"),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),
    'APP_ENV' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'Asia/Dhaka',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    'PROJECT_ROOT' => env('PROJECT_ROOT', 'http://localhost:8000'),
    'project_name' => env('PROJECT_NAME', 'OSS-Framework'),

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */


    /*
    |--------------------------------------------------------------------------
    | REDIS Configuration
    |--------------------------------------------------------------------------
    */

    'REDIS_HOST' => env('REDIS_HOST', '127.0.0.1'),
    'REDIS_PASSWORD' => env('REDIS_PASSWORD', null),
    'REDIS_PORT' => env('REDIS_PORT', '6379'),

    /*
    |--------------------------------------------------------------------------
    | Other Configuration
    |--------------------------------------------------------------------------
    */
    'upload_doc_path' => env('UPLOAD_DOC_PATH', 'uploads/'),
    'mongo_audit_log' => env('mongo_audit_log', 'false'),

    /*
   |--------------------------------------------------------------------------
   | Email & SMS Webservice Configuration
   |--------------------------------------------------------------------------
   */
    'SMS_API_URL_FOR_TOKEN' => env('SMS_API_URL_FOR_TOKEN', 'https://idp.oss.net.bd/auth/realms/dev/protocol/openid-connect/token'),
    'SMS_CLIENT_ID' => env('SMS_CLIENT_ID', 'bisic-oss-client'),
    'SMS_CLIENT_SECRET' => env('SMS_CLIENT_SECRET', '147cff25-f852-476a-b40c-e2270bb3a9df'),
    'SMS_GRANT_TYPE' => env('SMS_GRANT_TYPE', 'client_credentials'),
    'EMAIL_API_URL_FOR_SEND' => env('EMAIL_API_URL_FOR_SEND', 'https://api-k8s.oss.net.bd/api/broker-service/email/send_email'),
    'EMAIL_FROM_FOR_EMAIL_API' => env('EMAIL_FROM_FOR_EMAIL_API', 'onestopservice@bscic.gov.bd'),
    'SMS_API_URL_FOR_SEND' => env('SMS_API_URL_FOR_SEND', 'https://api-k8s.oss.net.bd/api/broker-service/sms/send_sms'),

    'SOCIAL_WIDGET_KEY' => env('SOCIAL_WIDGET_KEY', 'f05cc679-71b5-4fa5-8c56-d26ab0b6ccdb'),
    'PDF_API_BASE_URL' => env('PDF_API_BASE_URL', 'https://devpdfservice.pilgrimdb.org:8092/'),
    
    'is_mobile' => env('IS_MOBILE', false),

    'NOCAPTCHA_SECRET' => env('NOCAPTCHA_SECRET', '6Lea1TUhAAAAAOmhcgvJZnTa8dTm0a1ZDQXBn_1j'),
    'NOCAPTCHA_SITEKEY' => env('NOCAPTCHA_SITEKEY', '6Lea1TUhAAAAAC4Y2kAsaXLRaYRz0-1iWzhomhgx'),

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */
        Jenssegers\Agent\AgentServiceProvider::class,
        Milon\Barcode\BarcodeServiceProvider::class,
        Yajra\DataTables\DataTablesServiceProvider::class,
        Arcanedev\LogViewer\LogViewerServiceProvider::class,
        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\GlobalApplicationSettingProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => Facade::defaultAliases()->merge([
        // 'ExampleClass' => App\Example\ExampleClass::class,
        'CommonFunction' => App\Libraries\CommonFunction::class,
        'Encryption' => App\Libraries\Encryption::class,
        'ACL' => App\Libraries\ACL::class,

//        'Form' => Collective\Html\FormFacade::class,
//        'Html' => Collective\Html\HtmlFacade::class,

        'Agent' => Jenssegers\Agent\Facades\Agent::class,
        'DNS1D' => Milon\Barcode\Facades\DNS1DFacade::class,
        'DNS2D' => Milon\Barcode\Facades\DNS2DFacade::class,
    ])->toArray(),

];
