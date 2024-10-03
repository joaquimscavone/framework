<?php


if (!function_exists("view_path")) {
    function view_path($view_file)
    {
        $view_file = str_replace(".", DIRECTORY_SEPARATOR, $view_file);
        $view_file .= (defined('VIEWS_EXT')) ? constant('VIEWS_EXT') : '.php';
        return (defined('VIEWS_PATH')) ? constant('VIEWS_PATH') . DIRECTORY_SEPARATOR . $view_file : $view_file;
    }
}
if (!function_exists("view")) {
    function view($view_file, $template_file = null)
    {
        $view = view_path($view_file);

        if (file_exists($view)) {
            $view = new Fmk\MVC\View($view);
            $view = $view->render(); //codigo html da view;
            if(isset($template_file)){
                $template = template_path(template_file: $template_file);
                if(!file_exists($template)){
                    throw new Exception(message: "O Template $template não foi encontrada.");
                }
                $template= new Fmk\MVC\View($template); // virou objeto
                $template = $template->render(); // virou html;
                $view = str_replace('{{$VIEW}}', $view, $template);
            }
        } else {
            throw new Exception("A view $view não foi encontrada.");
        }
        return $view;
    }
}