<?php

namespace Fmk\Database\Drivers;

use Fmk\Database\Builder;
use Fmk\Database\Connection;

abstract class Driver
{
    protected static $parameters_default = [];
    protected array $parameters;
    private $connection;

    protected $sql;

    protected $data = [];

    public function __construct($parameters)
    {
        $this->parameters = array_merge(static::$parameters_default, $parameters);
    }

    public function getConnection()
    {
        if (is_null($this->connection)) {
            $this->connection = Connection::getConnection(
                $this->getDSN(),
                $this->parameters['user'],
                $this->parameters['password'],
                $this->parameters['options'],
            );
        }
        return $this->connection;
    }

    public function __get($name)
    {
        // return (isset($this->parameters[$name]))?$this->parameters[$name]:null;
        return $this->parameters[$name] ?? null;
    }
    abstract protected function getDSN();



    public function toSql(){
        $query = $this->sql ?? "";
        foreach($this->data as $key => $value){
            if(is_string($key)){
                $query = str_replace(":$key", "'" . addslashes($value) . "'", $query);
            }else{
                $query = $query = preg_replace('/\?/', "'" . addslashes($value) . "'", $query);
            }
        }
        return $query;
    }

    public function exec(){
        if(empty($this->sql)){
            throw new \Exception("SQL empty!");
        }
        $stm = $this->getConnection()->prepare($this->sql);
        $stm->execute($this->data);
        return $stm;
    }

    public function insert($tabela, array $data)
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', :', array_keys($data));
        $this->sql = "INSERT INTO $tabela ($columns) VALUES (:$values);";
        $this->data = $data;
        return $this;
       
    }

    public function select($tabela, $columns = ['*'], Builder $builder = null){
        $columns = implode(', ', $columns);
        // "SELECT * FROM TABELA;"
        if($builder){
            [$where,$data] = $builder->compiler();
            $this->data = $data;
        }
        $this->sql = "SELECT $columns FROM $tabela$where;";
        return $this;
    }







}