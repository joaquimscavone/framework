<?php

if(!function_exists('scripts')){
    function scripts($scripts_name){
        $scripts = (is_array($scripts_name))?$scripts_name:func_get_args();
        return Fmk\Components\ScriptsComponent::getInstance()->add($scripts);
    }
}