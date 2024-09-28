<?php

if (!function_exists("view_path")) {
    function view_path($view_file)
    {
        $view_file = str_replace(".", DIRECTORY_SEPARATOR, $view_file);
        $view_file .= (defined('VIEWS_EXT')) ? constant('VIEWS_EXT') : '';
        return (defined('VIEWS_PATH')) ? constant('VIEWS_PATH') . DIRECTORY_SEPARATOR . $view_file : $view_file;
    }
}
if (!function_exists("view")) {
    function view($view_file, array $data = [], $template = 'default')
    {
        $view = view_path($view_file);
        if (file_exists($view)) {
            $view = (new Fmk\Core\View($view))->render($data);
        } else {
            throw new Exception("A view $view não foi encontrada.");
        }
        return $view;
    }
}