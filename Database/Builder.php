<?php

namespace Fmk\Database;

use Closure;

class Builder
{
    protected $wheres;

    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        if ($column instanceof Closure) {
            $query = new self();
            $column($query);
            $type = 'Nested';
            $this->wheres[] = compact('type', 'query', 'boolean');
            return $this;
        }
        $type = 'Basic';
        $this->wheres[] = compact('type', 'column', 'operator', 'value', 'boolean');
        return $this;
    }
    public function orWhere($column, $operator = null, $value = null)
    {
        return $this->where($column, $operator, $value, 'or');
    }


    public function isEmpty(){
        return empty($this->wheres);
    }

    public function compile()
    {
        if(empty($this->wheres)){
            return ["",[]];
        }
        [$sql, $data] = $this->compileWheres();
        return [" WHERE ".$sql, $data];
    }

    protected function compileWheres($prefix = "_w_")
    {
        $sql = [];
        $data = [];
        foreach ($this->wheres as $index => $where) {
            if ($where['type'] == 'Basic') {
                $condition = $where['column'] . " " . $where['operator'] . " :$prefix$index";
                $data[$prefix . $index] = $where['value'];
            }else{
                [$nested, $nestedata] = $where['query']->compileWheres("{$prefix}{$index}_{$prefix}");
                $nested = "(".$nested.")";
                $condition = $nested;
                $data = array_merge($data,$nestedata);
            }
            $boolean = ($index==0)? "" : strtoupper($where['boolean'])." ";
            $sql[] = $boolean.$condition;
        }
        return [implode(' ',$sql),$data];
    }
}
