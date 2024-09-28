<?php

namespace Fmk;

class Initialize{
    public static function run(){
        self::loadConfigs();
        self::loadHelpers();
    }

    private static function loadConfigs(){
        require_once (__DIR__ .DIRECTORY_SEPARATOR."Configs".DIRECTORY_SEPARATOR."constantes.php");
    }

    private static function loadHelpers(){
        $helpers = glob(__DIR__ . DIRECTORY_SEPARATOR . "Helpers" . DIRECTORY_SEPARATOR . "/*.php");
        foreach ($helpers as $helper) {
            require_once $helper;
        }
    }
}
