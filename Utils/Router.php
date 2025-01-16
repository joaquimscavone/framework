<?php


namespace Fmk\Utils;

class Router{
    protected static $routes = [];

    protected static $error404;

    protected static $error403;

    public static function swapName($old_name, $new_name){
        if(self::$routes[$old_name]){
            self::$routes[$new_name] = &self::$routes[$old_name];
            unset(self::$routes[$old_name]);
            return self::$routes[$new_name];
        }
        return false;
    }

    public static function getRouteByUri($uri, $method="GET"){
        $uri = self::checkUri($uri);
        foreach(self::$routes as $key => $route){
            if($route->getMethod() !== strtoupper($method)){
                continue;
            }
            $expression = preg_replace("(\{[a-z0-9_]{1,}\})","([a-zA-Z0-9_\-|\s]{1,})",$route->getUri());
            if(preg_match("#^($expression)$#i",$uri, $mathes) === 1){
                array_shift($mathes);
                array_shift($mathes);
                $route->defineParameters($mathes);
                return $route;
            }
        }
        return false;
    }

    protected static function add($uri,$callback,$method="GET"){
        $key = count(self::$routes);
        self::$routes[$key] = new Route($key,self::checkUri($uri),$method, $callback);
        return self::$routes[$key];
    }

    public static function get($uri, $callback){
        return self::add($uri,$callback);
    }
    public static function post($uri, $callback){
        return self::add($uri,$callback, 'POST');
    }

    public static function getRouteByName($name){
        return self::$routes[$name] ?? null;
    }

    protected static function checkUri($uri){
        if(empty(trim($uri)) || $uri=="/"){
            return "/";
        }
        $uri = (substr($uri,0,1) === "/") ? $uri: "/$uri";  
        return rtrim($uri,"/");
    }

    public static function defineError404(callable $callback){
        self::$error404 = $callback;
    }
    public static function defineError403(callable $callback){
        self::$error403 = $callback;
    }

    public static function error404(string $msg = 'Not Found!'){
        if(is_callable(self::$error404)){
            $function = self::$error404;
            return $function($msg);
        }
        http_response_code(404);
        echo "404 - $msg";
        exit();
    }
    public static function error403(string $msg = 'Forbidden!'){
        if(is_callable(self::$error403)){
            $function = self::$error403;
            return $function($msg);
        }
        http_response_code(403);
        echo "403 - $msg";
        exit();
    }


}