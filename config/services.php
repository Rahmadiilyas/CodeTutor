<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Layanan Pihak Ketiga
    |--------------------------------------------------------------------------
    */

    // Pengaturan Gemini untuk Chatbot AI CodeTutor.
    'gemini' => [
        'api_key' => env('GEMINI_API_KEY'),
        'model' => env('GEMINI_MODEL', 'gemini-3.5-flash-lite'),
    ],

    // Pengaturan Judge0 untuk menjalankan kode dari Code Editor.
    'code_execution' => [
        'base_url' => env('CODE_EXECUTION_BASE_URL', 'https://ce.judge0.com'),
        'api_key' => env('CODE_EXECUTION_API_KEY', ''),
        'connect_timeout' => (int) env('CODE_EXECUTION_CONNECT_TIMEOUT', 3),
        'timeout' => (int) env('CODE_EXECUTION_TIMEOUT', 15),
    ],

    // Layanan lain yang mungkin digunakan aplikasi.
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

];
