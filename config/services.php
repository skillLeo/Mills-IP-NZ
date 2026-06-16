<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'ip_australia' => [
        'client_id'     => env('IP_AUSTRALIA_CLIENT_ID'),
        'client_secret' => env('IP_AUSTRALIA_CLIENT_SECRET'),
        'token_url'     => env('IP_AUSTRALIA_TOKEN_URL'),
        'base_url'      => env('IP_AUSTRALIA_BASE_URL'),
    ],

    'mills_ip' => [
        'notification_email' => env('MILLS_IP_NOTIFICATION_EMAIL', 'admin@millsip.com.au'),
    ],

];
