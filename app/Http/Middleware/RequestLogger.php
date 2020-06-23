<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Boolean;

class RequestLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $canWriteTrace = $this->canWriteTrace($request);
        if ($canWriteTrace) {
            \Log::channel('trace')->info("Request {$request->method()} url={$request->fullurl()}");
        }

        $canWriteBody = $this->canWriteBody($request);
        if ($canWriteBody) {
            $body = implode($request->all());
            \Log::channel('debug')->info("Request body = {$body}");
        }
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
