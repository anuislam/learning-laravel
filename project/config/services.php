<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],


    'facebook' => [
        'client_id' => env('facebook_client_id'),         // Your GitHub Client ID
        'client_secret' => env('facebook_client_secret'), // Your GitHub Client Secret
        'redirect' => Config('app.url').'/admin-panel/action/facebook/callback'
    ],

    'twitter' => [
        'client_id' => env('twitter_client_id'),         // Your GitHub Client ID
        'client_secret' => env('twitter_client_secret'), // Your GitHub Client Secret
        'redirect' => Config('app.url').'/admin-panel/action/twitter/callback'
    ],

    'google' => [
        'client_id' => env('google_client_id'),         // Your GitHub Client ID
        'client_secret' => env('google_client_secret'), // Your GitHub Client Secret
        'redirect' => Config('app.url').'/admin-panel/action/google/callback'
    ],

];
