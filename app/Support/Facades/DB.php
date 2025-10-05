<?php

namespace App\Support\Facades;

use App\Support\Facade;

class DB extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'db.builder';
    }
}