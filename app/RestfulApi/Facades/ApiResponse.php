<?php

namespace App\RestfulApi\Facades;

use Illuminate\Support\Facades\Facade;

class ApiResponse extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'api.response.builder'; // This will be the binding name in the service container
    }
}
