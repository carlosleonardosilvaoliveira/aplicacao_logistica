<?php

namespace App\Http\Middleware;

use \App\Session\Login as SessionLogin;

class RequireLogin
{
    public function handle($request, $next)
    {
        if(!SessionLogin::isLogged()) {
            $request->getRouter()->redirect('/');
        }

        return $next($request);
    }
}