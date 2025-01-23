<?php

namespace Fmk\Middlewares;

use Fmk\Interfaces\Middleware;
use Fmk\Utils\CSRF;
use Fmk\Utils\Request;
use Fmk\Utils\Route;
use Fmk\Utils\Router;

class CSRFMiddleware implements Middleware{
    public function check():bool{
        $request = Request::getInstance();
        if($request->getMethod() === 'POST'){
            return CSRF::check($request->{CSRF::TOKEN_NAME});
        }
        return true;
    }

    public function handle(){
        return Router::error403('CSRF Token invalid!');
    }
}