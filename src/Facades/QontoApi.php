<?php

namespace Brocorp\Qonto\Facades;

use Illuminate\Support\Facades\Facade;

class QontoApi extends Facade
{
    protected static function getFacadeAccessor() 
    { 
        return 'qonto_api'; 
    }
}