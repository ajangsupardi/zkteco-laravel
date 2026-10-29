<?php

namespace Rynest\Zkteco\Facades;

use Illuminate\Support\Facades\Facade;

class Zkteco extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'zkteco';
    }
}
