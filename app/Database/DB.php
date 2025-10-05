<?php

namespace App\Database;

use App\Core\Container;

class DB
{
    private static ?Connection $connection;
    protected static ?QueryBuilder $queryBuilder = null;

    public function __construct(protected Container $app)
    {
        $this->connection = $app->get('db');
    }

    public static function table(string $table, array $config): QueryBuilder
    {
        if (!self::$queryBuilder) {
            $pdo = self::$connection->getConnectionObject();
            self::$queryBuilder = new QueryBuilder($pdo);
        }

        return self::$queryBuilder->table($table);
    }
}