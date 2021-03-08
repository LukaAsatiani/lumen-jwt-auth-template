<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Traits\CustomResponse;
use App\Traits\User;
use Closure;

class RolesMiddleware{
    use User, CustomResponse;

    public function handle($request, Closure $next, $user){
        if($user !== $this->getRole())
            return $this->respondWithError('error.user.permission', 403);

        $response = $next($request);
        return $response;
    }
}
