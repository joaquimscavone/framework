<?php

if(!function_exists('assets')){
    function assets($path){
        $base_url = defined('APPLICATION_URL')?constant('APPLICATION_URL'):'';
        return $base_url."/assets/".$path;
    }
}