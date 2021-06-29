<?php

return [
    'api' => [
        'base_uri' => env('AIRLST_CORE_SDK_API_BASE_URI', 'https://v1.api.airlst.com/api'),
        'debug' => (bool) env('AIRLST_CORE_SDK_API_DEBUG', false),
        'auth_token' => env('AIRLST_CORE_SDK_API_AUTH_TOKEN'),
    ],
    'webhooks' => [
        'secret' => env('AIRLST_CORE_SDK_WEBHOOK_SECRET')
    ],
];
