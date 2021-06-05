<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Telegram api base uri
    |--------------------------------------------------------------------------
    |
    | https://api.telegram.org/bot<token>/METHOD_NAME
    |
    */

    'base_uri' => env('TELEGRAM_BOT_API_URL', 'https://api.telegram.org'),

    /*
    |--------------------------------------------------------------------------
    | Errors logging
    |--------------------------------------------------------------------------
    |
    | 0 - Disabled
    | 1 - Enabled
    |
    */

    'log_level' => env('TELEGRAM_BOT_DEBUG_ERRORS_LEVEL', 1),

    /*
    |--------------------------------------------------------------------------
    | Errors logs saving path
    |--------------------------------------------------------------------------
    |
    */

    'log_channel' => config('logging.default', ['path' => storage_path('logs/telegram-bot.log')]),

];
