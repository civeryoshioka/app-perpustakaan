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

    /*
    |--------------------------------------------------------------------------
    | Internal API Base URL
    |--------------------------------------------------------------------------
    |
    | `php artisan serve` memakai PHP built-in server yang cuma memproses
    | satu request pada satu waktu (di Windows selalu begitu, karena fitur
    | multi-worker-nya butuh fork() yang tidak tersedia). Kalau controller
    | web memanggil Http::get() balik ke endpoint /api/... di port yang
    | sama, request itu akan deadlock selamanya — server sedang sibuk
    | memproses request luar, jadi tidak bisa menerima request dalam yang
    | ditunggu oleh request luar itu sendiri.
    |
    | Solusinya: jalankan instance kedua dari aplikasi yang sama di port
    | berbeda, khusus untuk menerima panggilan API internal ini. Server
    | utama (port aktif php artisan serve mahasiswa) tetap melayani
    | trafik browser seperti biasa.
    |
    */
    'internal_api' => [
        'base_url' => env('INTERNAL_API_URL', 'http://127.0.0.1:8011'),
    ],

];
