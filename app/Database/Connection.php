<?php

namespace App\Database;

use PDO;

class Connection 
{
    private ?PDO $pdo = null;
    
    public function __construct(array $config)
    {
        $connection = $config['default'];
        $db = $config['connections'][$connection];

        $dsn = "mysql:host={$db['host']};dbname={$db['database']};charset={$db['charset']}";
        $this->pdo = new PDO($dsn, $db['username'], $db['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }

    public function getConnectionObject(): PDO
    {
        return $this->pdo;
    }
}