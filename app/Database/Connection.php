<?php

namespace App\Database;

use PDO;

class Connection 
{
    private ?PDO $pdo = null;
    
    public function __construct(array $config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        $this->pdo = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }

    public function getConnectionObject(): PDO
    {
        return $this->pdo;
    }
}