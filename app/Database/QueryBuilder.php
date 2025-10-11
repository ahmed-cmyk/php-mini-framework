<?php

namespace App\Database;

use PDO;

class QueryBuilder {
    private array $bindings = [];
    private PDO $conn;
    private string $sql;
    private string $table;
    private array $wheres = [];

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function table(string $table): self
    {
        $this->reset();
        $this->table = $table;
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
        $this->wheres[] = [$column, $operator, $value];
        return $this;
    }

    public function limit(int $limit): self {
        $this->sql .= " LIMIT {$limit}";
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
    
    public function insert(array $data): bool
    {
        $this->ensureTableSet();
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) =>  ":$col", $columns);

        $this->sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $this->table,
            implode(", ", $columns),
            implode(", ", $placeholders)
        );

        return $this->execute();
    }

    public function update(array $data): bool
    {
        $this->ensureTableSet();
        $set = implode(', ', array_map(fn($col) => "$col = :$col", array_keys($data)));
        $this->sql = "UPDATE {$this->table} SET {$set}";

        return $this->execute();
    }

    public function delete(): bool
    {
        $this->ensureTableSet();
        $this->sql = "DELETE FROM {$this->table}";
        return $this->execute();
    }

    private function reset(): void
    {
        $this->sql = '';
        $this->bindings = [];
        $this->wheres = [];
    }

    private function execute(): bool
    {
        if ($this->wheres) {
            $conditions = array_map(fn($w) => "{$w[0]} {$w[1]} :where_{$w[0]}", $this->wheres);
            $this->sql .= " WHERE " . implode(' AND ', $conditions); 

            $this->bindings = array_merge(
                $this->bindings,
                array_combine(
                    array_map(fn($w) => "where_{$w[0]}", $this->wheres),
                    array_map(fn($w) => $w[2], $this->wheres)
                )
            );
        }

        $stmt = $this->conn->prepare($this->sql);
        return $stmt->execute($this->bindings);
    }

    private function ensureTableSet(): void
    {
        if (!$this->table) {
            throw new \RuntimeException("Table not set. Call table('table_name') first.");
        }
    }
}
