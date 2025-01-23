<?php

if(!function_exists('component')){
    function component($component_class, array $data = []){
        if(class_exists($component_class)){
            $component = new $component_class;
            return $component->add($data);
        }else{
            $component = config("components.$component_class");
            if(isset($component)){
                $component = new $component;
                return $component->add($data);
            }else{
                $component = new Fmk\Utils\Component(component_path($component_class));
                return $component->setData($data);
            }
        }
    }
}

if (!function_exists('component_path')) {
    /**
     * Cria o caminha para a pasta que armazena as views de components do sistema
     * @param mixed $component_file
     * @return string
     */
    function component_path($component_file)
    {
        $component_file = str_replace(".", DIRECTORY_SEPARATOR, $component_file);
        $component = (defined('VIEWS_EXT')) ? $component_file . constant('VIEWS_EXT') : $component_file . '.php';
        $component = (defined('COMPONENT_EXT')) ? $component_file . constant('COMPONENT_EXT') : $component;
        $component_path = (defined('VIEWS_PATH')) ? constant('VIEWS_PATH') . DIRECTORY_SEPARATOR . $component : $component;
        return (defined('COMPONENTS_PATH')) ? constant('COMPONENTS_PATH') . DIRECTORY_SEPARATOR . $component : $component_path;
    }

}