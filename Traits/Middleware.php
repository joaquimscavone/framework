<?php

namespace Fmk\Traits;

use Fmk\Utils\Config;

Trait Middleware{

    protected $middlewares = [
                                \Fmk\Middlewares\CSRFMiddleware::class,
                                // \Fmk\Middlewares\DuplicateRequestGuardMiddleware::class
                            ];

    protected function swapMiddlewares(){
        $middlewares = [];
        foreach($this->middlewares as $mid){
            if(!class_exists($mid)){
                $mid = Config::getConfig("middlewares.$mid");
            }
            $middlewares[] = $mid;
        }
        return array_unique($middlewares);
    }

    

    public function execMiddlewares(callable $handle = null){
        foreach($this->swapMiddlewares() as $mid){
            $middleware = new $mid;
            if(!$middleware instanceof \Fmk\Interfaces\Middleware){
                throw new \Exception("$mid not implements Middlware Iterface");
            }
            if(!$middleware->check()){
                
                if (is_null($handle)){
                    return $middleware->handle();
                }
                return $handle();
            }
        }
        return true;
    }

    public function checkMiddlewares(){
        return $this->execMiddlewares(function(){
            return false;
        });
    }


    public function middlewares($middlewares){
        $middlewares = (is_array($middlewares))?$middlewares: func_get_args();
        $this->middlewares = array_merge($this->middlewares, $middlewares);
        return $this;
    }
    
}