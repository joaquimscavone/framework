<?php

namespace Fmk\Database;

use Exception;
use Fmk\Database\Drivers\Driver;
use Fmk\Utils\Config;

class DB{
    protected $parameters;

    public function __construct($connection_name){
        $database_file = defined('DATABASES_CONFIG_FILE') ? constant('DATABASES_CONFIG_FILE') : 'database';
        $this->parameters = Config::getConfig("$database_file.$connection_name");
        if(!isset($this->parameters['driver'])){
            throw new Exception("Driver é um parametro obrigatório para estabelecer uma conexão com a base de dados");
        }
        if (!array_key_exists($this->parameters['driver'], constant('DATABASE_DRIVERS'))){
            throw new Exception("Driver {$this->parameters['driver']} não é suportado por essa versão do framework");
        }      
    }

    public function table($table_name){
        return new Query($this->getDriver(), $table_name);
    }

    public function exec(String $sql, array $data = []){
        return $this->getDriver()->execute($sql, $data);
    }


    protected function getDriver(): Driver{
        $drivers = constant('DATABASE_DRIVERS');
        $driver = $drivers[$this->parameters['driver']];
        return new $driver($this->parameters); 
    }

    public static function query($table_name){
        $database_file = defined('DATABASES_CONFIG_FILE') ? constant('DATABASES_CONFIG_FILE') : 'database';
        $conneciton_name = Config::getConfig("$database_file.connection_default");
        $conneciton_name = defined('DATABASE_CONNECTION_DEFAULT') ? constant('DATABASE_CONNECTION_DEFAULT') : $conneciton_name;
        if(is_null($conneciton_name)){
            throw new Exception("Para criar uma query diretamente você precisa definir uma conexõa padrão, para isso 
                                    defina a constante DATABASE_CONNECTION_DEFAULT com o nome da conexão ou 
                                    crie um key com o nome connection_default dentro do arquivo $database_file de configuração");
        }
        return (new DB($conneciton_name))->table($table_name);
    }
}