<?php

namespace App\Http\Middleware;

use Closure;

class ResponseMiddleware{
    public function handle($request, Closure $next){    
        $data = $next($request);

        return $data;
    }
}
