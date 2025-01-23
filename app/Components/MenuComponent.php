<?php

namespace App\Components;

use Fmk\Utils\Component;
use Fmk\Utils\Router;

class MenuComponent extends Component
{
    protected $route;

    protected $label;

    protected $active;

    protected $icon;
    public function __construct()
    {
    }

    public function add($data)
    {
        if(is_array($data)){
            extract($data);
        }
        $route = $route ?? $data;
        // $this->route = route($route);
        $this->route = Router::getRouteByName($route);
        if (is_null($this->route)) {
            throw new \Exception("Route $route não encontrada! na criação do menu");
        }
        $this->active = $this->route->isActive();
        $this->label = $label ?? ucfirst($route);
        $this->icon = $icon ?? null;
        return $this;
    }

    public function label(string $label)
    {
        $this->label = $label;
        return $this;
    }

    public function icon(string $icon)
    {
        $this->icon = $icon;
        return $this;
    }

    public function render(array $data = [])
    {
        $icon = ($this->icon) ? "<i class='$this->icon'></i>" : "";
        $active = ($this->active) ? " class='active'" : "";
        return " <li$active>
                    <a href='$this->route'>
                    $icon
                    <p>$this->label</p>
                    </a>
                </li>";
    }


}