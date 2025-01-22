<?php

if(!function_exists('user')){
    function user(){
        return Fmk\Utils\Session::getInstance()->getUser();
    }
}