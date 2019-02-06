<?php

namespace App\Http\Middleware;

use Closure;

class Language {

    public function handle($request, Closure $next) {
        $header = $request->header();
        $locale = (isset($header['language'][0]) && !empty($header['language'][0])) ? $header['language'][0] : config('app.locale');

        \App::setLocale($locale);

        if (false === \App::isLocale($locale)) {
            \App::setLocale(config('app.fallback_locale'));
        }
        
        //dd(\App::getLocale(), \App::isLocale($locale));
        
        return $next($request);
    }

}
