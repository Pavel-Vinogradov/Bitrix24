<?php

return [
    'host' => env('BITRIX24_ENDPOINT_URI'),
    'client_id' => env('BITRIX24_CLIENT_ID'),
    'client_secret' => env('BITRIX24_CLIENT_SECRET'),
    'oauthUrl' => 'https://oauth.bitrix.info/oauth/token',
    'authentication' => [
        'ttl' => [
            'accessToken' => 60 * 60,
            'refreshToken' => 60 * 60 * 24 * 30,
        ],
    ],
];
