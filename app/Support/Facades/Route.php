<?php

namespace App\Support\Facades;

use App\Support\Facade;

class Route extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'router';
    }
}