<?php

namespace Fmk\Utils;

class Config
{
    private static $configs = [];

    private function __construct()
    {
    }

    /**
     * Carrega variáveis de um arquivo php
     * @param string $file_name nome do arquivo sem a extensão .php
     * @return array
     */
    public static function getConfig(string $file_name)
    {
        $filter = explode('.', $file_name);
        $file_name = array_shift($filter);
        if (!isset(self::$configs[$file_name])) {
         
            $config_path = constant('APPLICATION_PATH');
            $config_path = defined('CONFIGS_PATH') ? constant('CONFIGS_PATH') : $config_path;
            $file = $config_path . DIRECTORY_SEPARATOR . $file_name . ".php";
            if (!file_exists($file)) {
                throw new \Exception("Arquivo de configuração $file não existe!");
            }
            self::$configs[$file_name] = require $file;
        }

        return (empty($filter))?self::$configs[$file_name]:
            self::filter(self::$configs[$file_name],$filter);
    }

    private static function filter($data, $filter){
        foreach($filter as $key){
            if(!isset($data[$key])){
                return null;
            }
            $data = $data[$key];
        }
        return $data;
    }
}