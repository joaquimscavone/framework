<?php

namespace Fmk\Database\Drivers;

use Fmk\Database\Connection;

abstract class Driver{
    protected static $parameters_default = [];
    protected array $parameters;
    private $connection;

    public function __construct($parameters)
    {
        $this->parameters = array_merge(static::$parameters_default, $parameters);
    }

    public function getConnection(){
        if(is_null($this->connection)){
            $this->connection = Connection::getConnection(
                $this->getDSN(),
                $this->parameters['username'],
                $this->parameters['password'],
                $this->parameters['options'],
            );
        }
        return $this->connection;
    }

    public function __get($name){
            // return (isset($this->parameters[$name]))?$this->parameters[$name]:null;
            return $this->parameters[$name] ?? null;
    }
    abstract protected function getDSN();

}