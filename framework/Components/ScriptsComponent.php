<?php


namespace Fmk\Components;

use Fmk\Utils\Component;
use Fmk\Utils\Config;

class ScriptsComponent extends Component{
    protected static $instance;
    protected $scripts;


    private function __construct(){
        $scripts = Config::getConfig('scripts');
        foreach($scripts as $key => $script){
            $this->scripts[$key]['script'] = $script;
            $this->scripts[$key]['use'] = false;
        }
    }


    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function add($script_name){
        $scripts = (is_array($script_name))?$script_name:func_get_args();
        foreach($scripts as $script_name){
              if(array_key_exists($script_name,$this->scripts)){
            $this->scripts[$script_name]['use'] = true;
        }
        }
        return $this;
    }

    public function render(array $data = []){
        $this->add($data);
        ob_start();
        foreach($this->scripts as $script){
            if($script['use']){
                echo "<script src=\"{$script['script']}\"></script>";
            }
        }
        return ob_get_clean();
    }
}