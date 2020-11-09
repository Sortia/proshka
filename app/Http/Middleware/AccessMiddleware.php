<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $type
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $type)
    {
        if ($type === 'lesson') {
            $lesson = $request->route()->parameter('lesson');

            if (!$lesson->isActive()) {
                abort(404);
            }
        }

        return $next($request);
    }
}
