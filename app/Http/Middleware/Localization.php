<?php

namespace App\Http\Middleware;

use Closure;

class Localization {

    /**
     * Handle an incoming request.
     * https://dev.to/fadilxcoder/adding-multi-language-functionality-in-a-website-developed-in-laravel-4ech
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (\Session::has('locale')) {
            \App::setlocale(\Session::get('locale'));
        }
        return $next($request);
    }

}
