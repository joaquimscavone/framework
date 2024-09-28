<?php

namespace Fmk\Core;

class View{

    private $view;

    public function __construct(string $view)
    {
        $this->view = $view;
    }

    public function render(array $data = []){
        ob_start();
        extract($data);
        include $this->view;
        $content = ob_get_clean();
        return $content;
    }
}