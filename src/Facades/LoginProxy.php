<?php 

namespace Olymbytes\Z00s\Facades;

use Illuminate\Support\Facades\Facade;

class LoginProxy extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'LoginProxy';
    }
}