<?php

use App\Logging\DebugLogger;
use App\Logging\TraceLogger;
use App\Logging\ErrorLogger;
use App\Logging\SqlLogger;
use App\Logging\StripeLogger;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

use function PHPSTORM_META\map;

return [

    'enable_request_log' => env('ENABLE_REQUEST_LOG', false),
    'enable_requestbody_log' => env('ENABLE_REQUESTBODY_LOG', false),


    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'debug' => [
            'driver' => 'custom',
            'via' => DebugLogger::class,
            'path' => storage_path('logs/debug/debug.log'),
            'level' => 'debug',
            'days' => 7,
        ],

        'trace' => [
            'driver' => 'custom',
            'via' => TraceLogger::class,
            'path' => storage_path('logs/trace/trace.log'),
            'level' => 'info',
            'days' => 14,
        ],

        'error' => [
            'driver' => 'custom',
            'via' => ErrorLogger::class,
            'path' => storage_path('logs/error/error.log'),
            'level' => 'error',
            'days' => 60,
        ],

        'sql' => [
            'driver' => 'custom',
            'via' => SqlLogger::class,
            'path' => storage_path('logs/sql/sql.log'),
            'level' => 'info',
            'days' => 30,
        ],

        'stripe' => [
            'driver' => 'custom',
            'via' => StripeLogger::class,
            'path' => storage_path('logs/stripe/stripe.log'),
            'level' => 'info',
            'days' => 365,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => 'debug',
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],
    ],

];
