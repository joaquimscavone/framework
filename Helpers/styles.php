<?php

if(!function_exists('styles')){
    function styles($styles_name){
        $styles = (is_array($styles_name))?$styles_name:func_get_args();
        return Fmk\Components\StylesComponent::getInstance()->add($styles);
    }
}