<?php

namespace App\Middlewares;

use Fmk\Interfaces\Middleware;
use Fmk\Utils\Router;
use Fmk\Utils\Session;

class NoAuthenticatedMiddleware implements Middleware{
    public function check():bool{
        return !Session::getInstance()->isLogged();
    }

    public function handle(){
        return Router::getRouteByName('home')->redirect();
    }
}