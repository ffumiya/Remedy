<?php

use App\Logging\DebugLogger;
use App\Logging\TraceLogger;
use App\Logging\ErrorLogger;
use App\Logging\SqlLogger;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    'enable_request_log' => env('ENABLE_REQUEST_LOG', false),
    'enable_requestbody_log' => env('ENABLE_REQUESTBODY_LOG', false),

    'default' => env('LOG_CHANNEL', 'stack'),

    /**
     *
     * チャネル一覧
     *
     * クリティカルログ
     * 内容：致命的なエラーを出力する
     * レベル：critical
     *
     * エラーログ
     * 内容：続行可能だが、修正が必要になるエラーを出力
     * レベル：error
     *
     * ★SQLログ
     * 内容：DBへの変更が生じる際に出力
     * レベル：notice
     *
     * ★トレースログ
     * 内容：ユーザーの行動を出力する
     * レベル：info
     *
     * ★入出力ログ
     * 内容：入出力をできるだけ出力する
     * レベル：debug
     * 備考：本番環境は出力しない
     *
     *
     *
     */

    'channels' => [

        'default' => [
            'driver' => 'stack',
            'channels' => ['critical', 'error',],
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

        'sql' => [
            'driver' => 'custom',
            'via' => SqlLogger::class,
            'path' => storage_path('logs/sql/sql.log'),
            'level' => 'info',
            'days' => 60,
        ],

        'inout' => [
            'driver' => 'custom',
            'via' => DebugLogger::class,
            'path' => storage_path('logs/debug/inout.log'),
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

    ],

];
