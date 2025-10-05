<?php

namespace App\Contracts\Support;

use ArrayAccess;

interface DataBag extends ArrayAccess
{
    public function offsetSet($key, $value): void;

    public function offsetExists($key): bool;

    public function offsetUnset($key): void;

    public function offsetGet($key): mixed;
}