<?php

namespace App\RestfulApi\Facades;

use Illuminate\Support\Facades\Facade;

class ApiResponse extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'apiResponse';
    }

}
