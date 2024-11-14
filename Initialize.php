<?php

namespace Fmk;

class Initialize{
    public static function run(){
        self::loadConfigs();
        self::loadHelpers();
        self::loadRoutes();
    }

    private static function loadConfigs(){
        $configs_path =__DIR__ .DIRECTORY_SEPARATOR."Configs".DIRECTORY_SEPARATOR;
        require_once ($configs_path."constantes.php");
        $drivers['DATABASE_DRIVERS'] = require_once $configs_path . "database_drivers.php";
        self::createConstants($drivers);
    }

    private static function loadHelpers(){
        $helpers = glob(__DIR__ . DIRECTORY_SEPARATOR . "Helpers" . DIRECTORY_SEPARATOR . "/*.php");
        foreach ($helpers as $helper) {
            require_once $helper;
        }
    }
    private static function loadRoutes(){
        $routes = glob(ROUTES_PATH ."/*.php");
        foreach ($routes as $route) {
            require_once $route;
        }
    }

    public static function createConstants(array $constants){
        foreach($constants as $name => $value){
            defined($name) || define($name, $value);
        }
    }
}
