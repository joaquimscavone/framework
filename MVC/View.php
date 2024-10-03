<?php

namespace Fmk\MVC;

class View{

    private $view;

    public function __construct(string $view)
    {
        $this->view = $view;
    }

    public function render(){
        ob_start();
        include $this->view;
        $content = ob_get_clean();
        return $content;
    }
}