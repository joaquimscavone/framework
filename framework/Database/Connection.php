<?php

namespace Fmk\Database;

use Exception;
use PDO;
use PDOException;

class Connection{
    protected static $connections;

    private function __construct()
    { 
    }

    public static function getConnection($dsn, $username = null, $password = null, $options = null){
        $key = $dsn.$username;    
        $env = defined('APPLICATION_ENV')?constant('APPLICATION_ENV'):'production';
        if(!isset(self::$connections[$key])){
            try{
                $pdo = new PDO($dsn,$username,$password,$options);
                $env === 'production' || $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$connections[$key] = $pdo;
            }catch(PDOException $e){
                //procedimento
               throw $e;
            }
        }
        return self::$connections[$key];
    }

}



