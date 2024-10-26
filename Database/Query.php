<?php

namespace Fmk\Database;

use Fmk\Database\Drivers\Driver;

class Query{

    protected Driver $driver;
    protected string $table;

    protected Builder $builder;

    protected $limit = null;

    protected $offset = null;
    protected $orders = [];
    protected array $columns = ['*'];

    public function __construct(Driver $driver, $table){
        $this->driver = $driver;
        $this->table = $table;
        $this->builder = new Builder;
    }

    public function get(){
        return $this->driver->select(
            $this->table,
            $this->columns,
            $this->builder,
            $this->orders,
            $this->limit,
            $this->offset,
        )->exec()->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function first(){
        return $this->driver->select(
            $this->table,
            $this->columns,
            $this->builder,
            $this->orders,
            $this->limit,
            $this->offset,
        )->exec()->fetch(\PDO::FETCH_ASSOC);
    }

    public function insert(array $data){
        $this->driver->insert($this->table, $data)->exec();
        return $this->lastInsertId();
    }

    public function update(array $data){
        if($this->builder->isEmpty()){
            throw new \Exception("Não é possível executar update sem Where");
        }
        return $this->driver->update($this->table, $data, $this->builder)->exec();
    }
    public function delete(){
        if($this->builder->isEmpty()){
            throw new \Exception("Não é possível executar delete sem Where");
        }
        return $this->driver->delete($this->table,  $this->builder)->exec();
    }

    public function lastInsertId(){
        return $this->driver->lastInsertId($this->table);
    }


    public function select($columns){
        $this->columns = (is_array($columns)) ? $columns : func_get_args();
        return $this;
    }

    public function where($column, $operator = null, $value = null){
        $this->builder->where($column, $operator, $value);
        return $this;
    }
    public function orWhere($column, $operator = null, $value = null){
        $this->builder->orWhere($column, $operator, $value);
        return $this;
    }

    public function limit(int $limit, int $offset = null){
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }

    public function orderDesc($column){
        $this->orders[] = [$column, 'desc'];
        return $this;
    }
    public function order($column){
        $this->orders[] = [$column, 'asc'];
        return $this;
    }
    public function orderAsc($column){
        $this->orders[] = [$column, 'asc'];
        return $this;
    }
}