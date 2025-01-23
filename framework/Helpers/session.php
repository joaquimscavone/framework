<?php


if(!function_exists('session')){
    function session($name = null,$default=null){
        $session = \Fmk\Utils\Session::getInstance();
        if(isset($name)){
            return $session->$name ?? $default;
        }
        return $session;
    }
}