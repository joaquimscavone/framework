<?php

namespace Fmk\MVC;

class View{

    protected $view;

    protected $data = [];

    public function __construct(string $view)
    {
        $this->view = $view;
    }

    public function setData($data){
        $this->data = $data;
        return $this;
    }

    //$data['name'] => joaquim  $name 
    public function render(array $data = []){
        ob_start();
        extract(array:array_merge($this->data, $data));
        include $this->view;
        $content = ob_get_clean();
        return $content;
    }
}