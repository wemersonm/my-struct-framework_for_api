<?php

namespace app\models;

use Exception;
use PDO;

class QueryBuilder
{
    private Filters $filters;
    private ?string $queryFilter = "";
    private string $fields = "*";
    public string $table = "";
    private array $values = [];
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getInsance()->getConnection();
    }

    public function setFilters(Filters $filters)
    {
        $this->filters = $filters;
        $this->queryFilter = $filters->get();
        $this->values = $filters->getValues();
        return $this;
    }

    public function setTable(string $table)
    {
        $this->table = $table;
        return $this;
    }
    public function setFields(string $fields)
    {
        $this->fields = $fields;
        return $this;
    }
    public function reset()
    {
        $this->queryFilter = '';
        $this->fields = "*";
        $this->table = "";
        $this->values = [];
    }

    public function selectAll(): array
    {
        $query = "SELECT {$this->fields} FROM {$this->table} {$this->queryFilter}";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($this->values);
        return $stmt->fetchAll();
    }
    public function findBy()
    {
        $query = "SELECT {$this->fields} FROM {$this->table} {$this->queryFilter}";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($this->values);
        return $stmt->rowCount() > 0 ? $stmt->fetch() : [];
    }

    public function create(array $data): bool
    {
        $format = "INSERT INTO ";
        $format .= $this->table . " (" . implode(" , ", array_keys($data)) . ")";
        $format .= " VALUES (:" . implode(", :", array_keys($data)) . ")";
        $stmt = $this->pdo->prepare($format);
        return $stmt->execute($data) ? true : false;
    }
    public function update(array $data)
    {
        $format = "UPDATE ";
        $format .= $this->table . " SET ";
        foreach (array_keys($data) as $field) {
            $format .= "{$field} = :{$field}_, ";
        }
        $format .= "updated_at_{$this->table} = NOW()";
        $data = $this->AddUnderscoreInData($data);
        $format .= $this->queryFilter;
        $stmt = $this->pdo->prepare($format);
        return $stmt->execute($data) ? true : false;
    }

    public function delete()
    {
        if (empty($this->queryFilter) && empty($this->values)) {
            throw new Exception("Condição e valores necessarios");
        }

        $format = "DELETE FROM {$this->table} {$this->queryFilter}";
        $stmt = $this->pdo->prepare($format);
        return $stmt->execute($this->values) ? $this : false;
    }

    private function AddUnderscoreInData(array $data)
    {
        foreach (array_keys($data) as $field) {
            $data[$field . "_"] = $data[$field];
            unset($data[$field]);
        }
        return !empty($this->values) ? array_merge($this->values, $data) : $data;
    }

   
}
