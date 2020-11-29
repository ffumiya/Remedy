<?php

use App\Logging\DebugLogger;
use App\Logging\TraceLogger;
use App\Logging\ErrorLogger;
use App\Logging\SqlLogger;
use Monolog\Handler\StreamHandler;

return [

    'enable_request_log' => env('ENABLE_REQUEST_LOG', false),
    'enable_requestbody_log' => env('ENABLE_REQUESTBODY_LOG', false),
    'enable_debuglog' => env('LOG_DEBUG', false),
    'format' => env('LOG_FORMAT', 'text'),

    'default' => env('LOG_CHANNEL', 'stack'),

    'channels' => [

        'remedy' => [
            'driver' => 'stack',
            'channels' => ['critical', 'error', 'debug'],
            'ignore_exceptions' => false,
        ],

        'critical' => [
            'driver' => 'custom',
            'via' => ErrorLogger::class,
            'path' => storage_path('logs/critical/critical.log'),
            'level' => 'critical',
            'days' => 60,
        ],

        'error' => [
            'driver' => 'custom',
            'via' => ErrorLogger::class,
            'path' => storage_path('logs/error/error.log'),
            'level' => 'error',
            'days' => 60,
        ],

        'warning' => [
            'driver' => 'custom',
            'via' => ErrorLogger::class,
            'path' => storage_path('logs/warning/warning.log'),
            'level' => 'warning',
            'days' => 60,
        ],

        'alert' => [
            'driver' => 'custom',
            'via' => ErrorLogger::class,
            'path' => storage_path('logs/alert/alert.log'),
            'level' => 'alert',
            'days' => 60,
        ],

        'sql' => [
            'driver' => 'custom',
            'via' => SqlLogger::class,
            'path' => storage_path('logs/sql/sql.log'),
            'level' => 'info',
            'days' => 60,
        ],

        'trace' => [
            'driver' => 'custom',
            'via' => TraceLogger::class,
            'path' => storage_path('logs/trace/trace.log'),
            'level' => 'info',
            'days' => 14,
        ],

        'debug' => [
            'driver' => 'custom',
            'via' => DebugLogger::class,
            'path' => storage_path('logs/debug/debug.log'),
            'level' => 'debug',
            'days' => 7
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'path' => storage_path('logs/stderr/stderr.log'),
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],

    ],

];
