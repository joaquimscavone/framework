<?php

namespace App\Components;

use Fmk\Utils\Component;

class CardComponent extends Component{
    protected $prefix = '<div class="card">';
    protected $posfix = "</div>";

    protected $body;

    public function __construct(){
        $this->createBody();
    }

    private function createBody(){
        $this->body = new Component();
        $this->body->prefix = '<div class="card-body">';
        $this->body->posfix = "</div>";
        $this->add($this->body);
    }

    public function body(){
        return $this->body;
    }


}