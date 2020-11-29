<?php

namespace App\Logging;

use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class BasicLogger
{
    protected $method_names;
    protected $is_after = false;

    public function __construct()
    {
        $this->method_names = array();
    }

    public function critical($message)
    {
        Log::critical($this->buildMessage($message));
    }

    public function error($message)
    {
        Log::error($this->buildMessage($message));
    }

    public function alert($message)
    {
        Log::channel('alert')->alert($this->buildMessage($message));
    }

    public function warning($message)
    {
        Log::channel('warning')->warning($this->buildMessage($message));
    }

    public function sql($query)
    {
        if (is_string($query)) {
            $sql = $query;
        } else {
            $sql = $this->getBindedSql($query);
        }
        Log::channel('sql')->info($this->buildMessage($sql));
        $this->debug($sql);
    }

    public function sqlSelectStatement($query)
    {
        if (is_string($query)) {
            $sql = $query;
        } else {
            $sql = $this->getBindedSql($query);
        }
        $this->debug($sql);
    }

    public function trace($message)
    {
        $message = $this->buildMessage($message);
        Log::channel('trace')->info($message);
        $this->debug($message);
    }

    public function info($message)
    {
        $message = $this->buildMessage($message);
        Log::info($message);
        $this->debug($message);
    }

    public function debug($message)
    {
        if (config('logging.enable_debuglog')) {
            Log::debug($this->buildMessage($message));
        }
    }

    public function before($method_name)
    {
        array_push($this->method_names, $method_name);
        $this->debug("BEFORE");
    }

    public function after()
    {
        $this->is_after = true;
        $this->debug("AFTER");
    }

    private function buildMessage($message)
    {
        if (!is_string($message)) {
            $message = serialize($message);
        }

        if (count($this->method_names) > 0) {
            if ($this->is_after) {
                $method_name = array_pop($this->method_names);
                $this->is_after = false;
            } else {
                $method_name = end($this->method_names);
            }
            $message = "{$message} at {$method_name}";
        }

        return $message;
    }

    private function getBindedSql($query)
    {
        $sql = $query->sql;
        foreach ($query->bindings as $binding) {
            if (is_string($binding)) {
                $binding = "'{$binding}'";
            } elseif (is_bool($binding)) {
                $binding = $binding ? '1' : '0';
            } elseif ($binding === null) {
                $binding = 'NULL';
            } elseif ($binding instanceof Carbon) {
                $binding = "'{$binding->toDateTimeString()}'";
            } elseif ($binding instanceof DateTime) {
                $binding = "'{$binding->format('Y-m-d H:i:s')}'";
            }

            $sql = preg_replace("/\?/", $binding, $sql, 1);
        }
        return $sql;
    }
}
