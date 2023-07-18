<?php

namespace app\models;

class Filters
{
    private array $values = [];
    private array $filter = [];
    private string $query = "";


    public function where(string $field, string $operator, mixed $value, string $logic = "")
    {
        $this->filter['where'][] = "{$field} {$operator} :{$field} {$logic}";
        $this->values[$field] =  $value;
        return $this;
    }

    public function in(string $field, array $value, string $logic = "")
    {
        $format = "";
        $format .= " {$field} IN (" . implode(",", $value) . ")";

        $this->filter['in'][] = "{$format} {$logic}";
        return $this;
    }

    public function orderBy(string $field, string $order = "ASC")
    {
        $this->filter['orderby'] = " ORDER BY {$field} {$order} ";
        return $this;
    }

    public function limit(mixed $limit)
    {
        $this->filter['limit'] = " LIMIT {$limit} ";
        return $this;
    }

    public function join(string $table, string $fieldOne, string $operator, string $fieldTwo, string $join = "INNER JOIN")
    {
        $this->filter['join'][] = " {$join} {$table} ON {$fieldOne} {$operator} {$fieldTwo} ";
        return $this;
    }

    public function get()
    {
        $this->query .= isset($this->filter['join']) && count($this->filter['join']) > 0 ? implode(" ", $this->filter['join']) : "";

        $this->query .= isset($this->filter['where']) && count($this->filter['where']) > 0
            ?
            (strrpos($this->query, "WHERE") === false ?
                " WHERE " . implode("", $this->filter['where']) : implode("", $this->filter['where']))
            : "";
        $this->query .= isset($this->filter['in']) && count($this->filter['in']) > 0
            ?
            (strpos($this->query, "WHERE") === false ?
                " WHERE " . implode("", $this->filter['in']) : implode("", $this->filter['in']))
            : "";

        $this->query .= isset($this->filter['orderby']) ? $this->filter['orderby'] : "";
        $this->query .= isset($this->filter['limit']) ? $this->filter['orderby'] : "";
        
        return $this->query;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function getQuery()
    {
        return $this->query;
    }
}
