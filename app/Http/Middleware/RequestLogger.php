<?php

namespace App\Http\Middleware;

use App\Logging\DefaultLogger;
use Closure;
use Illuminate\Http\Request;

class RequestLogger
{

    public function handle(Request $request, Closure $next)
    {
        DefaultLogger::before(__METHOD__);
        $canWriteTrace = $this->canWriteTrace($request);
        // リクエストURLを出力
        if ($canWriteTrace) {
            DefaultLogger::trace("Request {$request->method()} URL={$request->fullurl()}");
        }

        // リクエストボディを出力
        $canWriteBody = $this->canWriteBody($request);
        if ($canWriteBody) {
            DefaultLogger::debug($request);
        }
        DefaultLogger::after();
        return $next($request);
    }

    private function canWriteTrace(Request $request): bool
    {

        if ($request->is('js/*')) {
            return false;
        }

        if (!config('logging.enable_request_log')) {
            return false;
        }

        return true;
    }

    private function canWriteBody(Request $request): bool
    {
        if (!$this->canWriteTrace($request)) {
            return false;
        }

        if (!config('logging.enable_requestbody_log')) {
            return false;
        }

        if (empty($request->all())) {
            return false;
        }

        return true;
    }
}
