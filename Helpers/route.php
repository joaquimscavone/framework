<?php

if(!function_exists('route')){
    function route($route_name){
        return  Fmk\Utils\Router::getRouteByName($route_name);
    }
}