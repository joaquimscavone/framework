<?php

if(!function_exists('config')){
    function config($config_name){
        return Fmk\Utils\Config::getConfig($config_name);
    }
}