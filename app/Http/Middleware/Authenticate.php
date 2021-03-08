<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\CustomResponse;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate{
    use CustomResponse;

    protected $auth;
    
    public function __construct(Auth $auth){
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $guard = null){
        if ($this->auth->guard($guard)->guest()) {
            return $this->respondWithError('error.unauthorized', 401);
        }

        return $next($request);
    }
}
