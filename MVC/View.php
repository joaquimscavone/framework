<?php

namespace Fmk\MVC;

class View{

    protected $view;

    public function __construct(string $view)
    {
        $this->view = $view;
    }

    //$data['name'] => joaquim  $name 
    public function render(array $data = []){
        ob_start();
        extract(array: $data);
        include $this->view;
        $content = ob_get_clean();
        return $content;
    }
}