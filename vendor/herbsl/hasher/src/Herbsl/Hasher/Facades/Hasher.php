<?php

namespace Herbsl\Hasher\Facades;

use Illuminate\Support\Facades\Facade;

class Hasher extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'hasher';
    }
}
