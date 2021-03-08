<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\CustomResponse;
use Laravel\Lumen\Application;

class LocalizationMiddleware {
    use CustomResponse;

    public function __construct(Application $app){
        $this->app = $app;
    }

    public function handle($request, Closure $next){
        $locale = $request->header('Content-Language');

        if(!$locale){
            $locale = $this->app->config->get('localization.locale');
        }

        $supported_languages = $this->app->config->get('localization.supported_languages');

        if (!array_key_exists($locale, $supported_languages)) {
            return $this->respondWithError('error.language', 403);
        }

        $this->app->setLocale($locale);
        $response = $next($request);
        $response->headers->set('Content-Language', $locale);
        return $response;
    }
}
