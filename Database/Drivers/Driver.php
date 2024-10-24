<?php

namespace Fmk\Database\Drivers;

use Fmk\Database\Builder;
use Fmk\Database\Connection;

abstract class Driver{
    protected static $parameters_default = [];
    protected array $parameters;
    private $connection;
    protected $sql;
    protected $data = [];

    public function __construct($parameters)
    {
        $this->parameters = array_merge(static::$parameters_default, $parameters);
    }

    public function getConnection(){
        if(is_null($this->connection)){
            $this->connection = Connection::getConnection(
                $this->getDSN(),
                $this->parameters['user'],
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



    public function insert(string $table, array $data){
        $columns  = implode(', ',array_keys($data));
        $values  = implode(', :',array_keys($data));
        $this->sql = "INSERT INTO $table ($columns) VALUES (:$values);";
        $this->data = $data;
        return $this;
    }

    /**
     * Cria uma Sql do tipo select para o drive selecionado.
     * @param string $table tabela do banco de dados
     * @param array $columns colunas que deve ser selecionada ex: ['id','nome']
     * @param \Fmk\Database\Builder|null $builder Where para filtrar os dados
     * @param array $order como os registros devem ser ordenados ex: [['nome','asc'],['descricao','desc']];
     * @return static
     */
    public function select(string $table, array $columns = ['*'], Builder $builder = null, array $orders = [], int $limit = null, int $offset = null){
        $columns  = implode(', ',$columns);
        [$where,$data] = $this->compileWhere($builder);
        $order = $this->compileOrder($orders);
        $limit = $this->compileLimit($limit, $offset);
        $this->sql = "SELECT $columns FROM $table$where$order$limit;";
        $this->data = $data;
        return $this;
    }


    public function update(string $table, array $data, Builder $builder = null){
        $sql = "UPDATE $table SET ";
        $comma = '';
        foreach($data as $key => $value){
            $sql .= $comma."$key = :$key";
            $comma = ", ";
        }
        [$where,$wdata] = $this->compileWhere($builder);
        $this->sql="$sql$where;";
        $this->data = array_merge($data,$wdata);
        return $this;
    }

    public function delete(string $table, Builder $builder = null){
        [$where, $wdata] = $this->compileWhere($builder);
        $this->sql = "DELETE FROM $table$where";
        $this->data = $wdata;
        return $this;
    }

    protected function compileWhere(Builder $builder = null){
        if(is_null(($builder))){
            return ['',[]];
        }
        return $builder->compile();
    }
    protected function compileOrder(array $orders = []){
        if(count($orders)){
            $sql = "";
            $comma = '';
            foreach($orders as $order){
                $sql.=$comma.array_shift($order);
                $sql.=(strtoupper(array_shift($order)??'asc')=='DESC')?' DESC':' ASC';
                $comma = ', ';
            }
            return " ORDER BY $sql";
        }
        return "";
    }

    protected function compileLimit(int $limit = null, int $offset = null){
        if(is_null(($limit))){
            return "";
        }
        $sql = " LIMIT $limit";
        if(isset($offset)){
            $sql.= ", $offset";
        }
        return $sql;
    }








    public function toSql(){        
        $query = $this->sql ?? "";
        foreach($this->data as $key => $value){
            if(is_string($key)){
                $query = str_replace(":".$key,"'".addslashes($value)."'",$query);
            }else{
                $query = preg_replace('/\?/',"'".addslashes($value)."'",$query);
            }
        }
        return $query;
    }


    /**
     * executa a query no banco de dados;
     */
    public function exec(){
        if (empty($this->sql)) {
            throw new \Exception("Não existe uma query montanda!");
        }
        $stm = $this->getConnection()->prepare($this->sql);
        $stm->execute($this->data);
        return $stm;
    }

    public function execute($sql,array $data = []){
        $this->sql = $sql;
        $this->data = $data;
        return $this->exec();
    }


}