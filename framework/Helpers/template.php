<?php
if (!function_exists("template_path")) {
    function template_path($template_file)
    {
        $template_file = str_replace(".", DIRECTORY_SEPARATOR, $template_file);
        $template = (defined('VIEWS_EXT')) ? $template_file.constant('VIEWS_EXT') : $template_file.'.php';
        $template = (defined('TEMPLATES_EXT')) ? $template_file.constant('TEMPLATES_EXT') : $template;
        $template_path =  (defined('VIEWS_PATH')) ? constant('VIEWS_PATH') . DIRECTORY_SEPARATOR . $template : $template;
        return (defined('TEMPLATES_PATH')) ? constant('TEMPLATES_PATH') . DIRECTORY_SEPARATOR . $template : $template_path;
    }
}