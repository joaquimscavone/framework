<?php

if(!function_exists('CSRF')){
    function CSRF(){
        $name = \Fmk\Utils\CSRF::TOKEN_NAME;
        $value = \Fmk\Utils\CSRF::token();
        return "<input type='hidden' name='$name' value='$value' >";
    }
}