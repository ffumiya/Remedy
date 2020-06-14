<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class StripeLogger
{
    const dateFormat = 'Y/m/d H:i:s';

    /**
     * カスタムMonologインスタンスの生成
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        // monologが理解できるlevel表記に変更
        $level = Logger::toMonologLevel($config['level']);
        // ルーティング設定
        $hander = new RotatingFileHandler($config['path'], $config['days'], $level);
        // ログのフォーマット指定
        $hander->setFormatter(new LineFormatter(null, self::dateFormat, true, true));
        $logger = new Logger('stripe');
        $logger->pushHandler($hander);
        return $logger;
    }
}
