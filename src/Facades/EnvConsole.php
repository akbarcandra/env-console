<?php

namespace Akbarcandra\EnvConsole\Facades;

use Illuminate\Support\Facades\Facade;

class EnvConsole extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'env-console';
    }
}
