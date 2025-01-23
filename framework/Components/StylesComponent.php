<?php


namespace Fmk\Components;

use Fmk\Utils\Component;
use Fmk\Utils\Config;

class StylesComponent extends Component{
    protected static $instance;
    protected $styles;


    private function __construct(){
        $styles = Config::getConfig('styles');
        foreach($styles as $key => $style){
            $this->styles[$key]['style'] = $style;
            $this->styles[$key]['use'] = false;
        }
    }


    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function add($style_name){
        $styles = (is_array($style_name))?$style_name:func_get_args();
        foreach($styles as $style_name){
              if(array_key_exists($style_name,$this->styles)){
            $this->styles[$style_name]['use'] = true;
        }
        }
        return $this;
    }

    public function render(array $data = []){
        $this->add($data);
        ob_start();
        foreach($this->styles as $style){
            if($style['use']){
                echo "<link rel='stylesheet' href='{$style['style']}'>";
            }
        }
        return ob_get_clean();
    }
}