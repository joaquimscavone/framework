<?php

namespace App\Components;

use Fmk\Utils\Component;
use Fmk\Utils\Config;
use Fmk\Utils\Session;

class NotifyComponent extends Component
{
    protected $config;

    public function __construct(){
        $this->config = Config::getConfig('notify');
    }

    protected static function addNotify($msg, $title, $icon, $type){
        $session = Session::getInstance();
        $notify = $session->notify ?? [];
        $notify[] = compact('msg','title','icon','type');
        $session->notify = $notify;
    }

    public static function info($msg, $title=null, $icon = 'fa fa-info-circle'){
        self::addNotify($msg,$title,$icon,'info');
    }
    public static function error($msg, $title=null, $icon = 'fa fa-exclamation-circle'){
        self::addNotify($msg,$title,$icon,'danger');
    }
    public static function warning($msg, $title=null, $icon = 'fa fa-exclamation-triangle'){
        self::addNotify($msg,$title,$icon,'warning');
    }
    public static function success($msg, $title=null, $icon = 'fa fa-check-circle'){
        self::addNotify($msg,$title,$icon,'success');
    }

    public function render(array $data = []){
        $this->add($data);
        foreach($this->content as $notify){
            self::info($notify);
        }
        $session = Session::getInstance();
        $notifys = $session->flush('notify');
        if($notifys){
            ob_start();
            echo '<script>';
            foreach($notifys as $notify){
                echo $this->renderNotify($notify);
            }
            echo '</script>';
            return ob_get_clean();
        }
        return "";
    }

    protected function renderNotify($notify){
        extract($notify);
        extract($this->config);
        if(isset($title)){
            $msg = "<b>$title</b> - $msg";
        }
        return "$.notify({
            icon: '$icon',
            message: '$msg',
            }, {
            type: '$type',
            timer: $timer,
            placement: {
                from: '$from',
                align: '$align'
            }
            });";
    }
}