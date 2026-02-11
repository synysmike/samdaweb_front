<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Base URL
    |--------------------------------------------------------------------------
    |
    | This is the base URL for the external API. You can set this in your
    | .env file using the API_BASE_URL variable.
    |
    */

    'base_url' => env('API_BASE_URL', 'http://36.93.42.27:4340'),

    /*
    |--------------------------------------------------------------------------
    | API Endpoints
    |--------------------------------------------------------------------------
    |
    | Define API endpoints here for easy maintenance.
    |
    */

    'endpoints' => [
        'auth' => [
            'login' => '/api/v1/auth/login',
            'register' => '/api/v1/auth/register',
            'logout' => '/api/v1/auth/logout',
        ],
        'settings' => [
            'update_profile' => '/api/v1/settings/update-profile',
            'change_password' => '/api/v1/settings/change-password',
            'shipping_address' => [
                'index' => '/api/v1/settings/shipping-address',
                'store' => '/api/v1/settings/shipping-address/store',
                'show' => '/api/v1/settings/shipping-address/show',
                'delete' => '/api/v1/settings/shipping-address/delete',
            ],
        ],
        'world' => [
            'countries' => '/api/v1/world/countries',
            'states' => '/api/v1/world/states',
            'cities' => '/api/v1/world/cities',
        ],
        'product_category' => [
            'get' => '/api/v1/product-category/get',
            'show' => '/api/v1/product-category/show',
            'store' => '/api/v1/product-category/store',
            'delete' => '/api/v1/product-category/delete',
        ],
        'product' => [
            'index' => '/api/v1/product/get',
            'store' => '/api/v1/product/store',
            'delete' => '/api/v1/product/delete',
        ],
        'product_image' => [
            'index' => '/api/v1/product-image/get',
            'store' => '/api/v1/product-image/store',
        ],
        'shop' => [
            'get' => '/api/v1/shop/get-shop',
            'store' => '/api/v1/shop/store-shop',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Helper Functions
    |--------------------------------------------------------------------------
    |
    | Helper function to get full API URL
    |
    */

];
