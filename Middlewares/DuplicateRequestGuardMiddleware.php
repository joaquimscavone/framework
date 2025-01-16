<?php

namespace Fmk\Middlewares;

use Fmk\Interfaces\Middleware;
use Fmk\Utils\CSRF;
use Fmk\Utils\Request;
use Fmk\Utils\Session;
use Fmk\Utils\Router;

class DuplicateRequestGuardMiddleware implements Middleware{
    public function check():bool{
        $request = Request::getInstance();
        if($request->getMethod() === 'POST'){
            $request_old = Session::getInstance()->request();
            return $request->getMethod() !== $request_old->getMethod()
                   || $request->getUri() !== $request_old->getUri()
                   || md5(implode('',$request->all())) !== 
                      md5(implode('',$request_old->all()));
        }
        return true;
    }

    public function handle(){
        return Session::getInstance()->requestOld()->getRoute()->redirect();
    }
}