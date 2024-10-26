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



    public function toSql()
    {
        $query = $this->sql ?? "";
        foreach ($this->data as $key => $value) {
            if (is_string($key)) {
                $query = str_replace(":$key", "'" . addslashes($value) . "'", $query);
            } else {
                $query = $query = preg_replace('/\?/', "'" . addslashes($value) . "'", $query);
            }
        }
        return $query;
    }

    public function exec()
    {
        if (empty($this->sql)) {
            throw new \Exception("SQL empty!");
        }
        $stm = $this->getConnection()->prepare($this->sql);
        $stm->execute($this->data);
        return $stm;
    }

    public function insert($table, array $data)
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', :', array_keys($data));
        $this->sql = "INSERT INTO $table ($columns) VALUES (:$values);";
        $this->data = $data;
        return $this;

    }
    protected function compileBuilder(Builder $builder = null)
    {
        if ($builder) {
            return $builder->compiler();
        }
        return ['', []];
    }

    protected function compileOrders($orders)
    {
        //[ ['column', 'asc|desc'],['column', 'asc|desc'] ];
        if (empty($orders)) {
            return "";
        }
        $sql = " ORDER BY ";
        $comma = "";
        foreach ($orders as $order) {
            $sql .= $comma . array_shift($order);
            $sql .= (strtoupper(array_shift($order) ?? 'asc') == 'DESC') ? " DESC" : " ASC";
            $comma = ", ";
        }
        return $sql;
    }

    protected function compileLimit(int $limit = null, int $offset = null)
    {
        if (is_null($limit)) {
            return "";
        }
        $sql = " LIMIT $limit";
        $sql .= (isset($offset)) ? ", $offset" : "";
        return $sql;
    }


    public function select($table, $columns = ['*'], Builder $builder = null, array $orders = [], int $limit = null, int $offset = null)
    {
        $columns = implode(', ', $columns);
        // "SELECT * FROM table;"
        [$where, $this->data] = $this->compileBuilder($builder);
        $orderby = $this->compileOrders($orders);
        $limitoff = $this->compileLimit($limit, $offset);
        $this->sql = "SELECT $columns FROM $table$where$orderby$limitoff;";
        return $this;
    }

    public function update($table, array $data, Builder $builder = null)
    {
        //UPDATE produtos SET nome = 'Halls', descricao = 'Bala Halls Mentolada' where id = 55
        $sql = "UPDATE $table SET ";
        $comma = "";
        foreach ($data as $key => $value) {
            $sql .= $comma . "$key = :$key";
            $comma = ", ";
        }
        [$where, $wdata] = $this->compileBuilder($builder);
        $this->sql = $sql . $where . ";";
        $this->data = array_merge($data, $wdata);
        return $this;
    }

    public function delete($table, Builder $builder = null)
    {
        $sql = "DELETE FROM $table";
        [$where, $this->data] = $this->compileBuilder($builder);
        $this->sql = "$sql$where;";
        return $this;
    }

    public function execute($sql, array $data = [])
    {
        $this->sql = $sql;
        $this->data = $data;
        return $this->exec();
    }

    public function lastInsertId(string $table){
        return $this->getConnection()->lastInsertId($table);
    }







}