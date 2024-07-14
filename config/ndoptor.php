<?php

return [
    'redirect_url' => env('REDIRECT_URL', 'http://n-doptor-api.nothi.gov.bd/login?referer='),
    'project_root' => env('PROJECT_ROOT'),
    'login_sso' => env('LOGIN_SSO', true),
    'login_sso_url' => env('LOGIN_SSO_URL', 'https://n-doptor-accounts.nothi.gov.bd/login'),
    'logout_sso_url' => env('LOGOUT_SSO_URL', 'https://n-doptor-accounts.nothi.gov.bd/logout?referer='),
    'login_api' => env('LOGIN_API', 'https://n-doptor-api.nothi.gov.bd/login'),
    'ndoptor_api_url' => env('NDOPTOR_API_URL', 'https://n-doptor-api.nothi.gov.bd/'),
];
