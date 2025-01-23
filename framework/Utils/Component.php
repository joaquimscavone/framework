<?php

namespace Fmk\Utils;

use Fmk\MVC\View;

class Component extends View{
    protected $prefix = '';

    protected $posfix = '';

    protected $content = [];
    public function __construct(string $view = null){
        if(isset($view)){
            parent::__construct($view);
        }
    }


    public function add($content){
        if(is_array($content)){
            foreach($content as $item){
                $this->add($item);
            }
            return $this;
        }

        $this->content[] = $content;
        return $this;
    }

    public function render(array $data = []){
        if(isset($this->view)){
            return parent::render($data);
        }
        $this->add($data);
        return $this->prefix.implode("",$this->content).$this->posfix;
    
    }

    public function __toString(){
        return $this->render();
    }
}