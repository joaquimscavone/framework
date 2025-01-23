<?php

if(!function_exists('route')){
    function route($route_name, array $paramns = []){
        return  Fmk\Utils\Router::getRouteByName($route_name)->setParamns($paramns);
    }
}