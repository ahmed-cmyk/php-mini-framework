<?php

namespace App\Database;

use PDO;

class QueryBuilder {
    private array $bindings = [];
    private PDO $conn;
    private string $sql;
    private string $table;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function table(string $table): self
    {
        $this->sql = "SELECT * FROM {$table}";
        return $this;
    }

    public function select(array $columns = ['*']): self
    {
        $cols = implode(',', $columns);
        $this->sql = "SELECT {$cols} FROM {$this->table}";
        return $this;
    }

    public function where(string $column, string $operator, mixed $value): self {
        // Using prepared statements with bound parameters helps us avoid SQL injection
        // We can use either a question mark or a key
        $this->sql .= "WHERE {$column} {$operator} ?";
        $this->bindings[] = $value;
        return $this;
    }

    public function limit(int $limit): self {
        $this->sql .= "limit {$limit}";
        return $this;
    }

    public function get(): array {
        $stmt = $this->conn->prepare($this->sql);
        $stmt->execute($this->bindings);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function first(): ?object {
        $stmt = $this->conn->prepare($this->sql . ' LIMIT 1');
        $stmt->execute($this->bindings);
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row ?: null;
    }
}
