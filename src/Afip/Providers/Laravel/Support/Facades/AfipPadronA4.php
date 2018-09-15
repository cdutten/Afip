<?php

namespace Afip\Providers\Laravel\Support\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * Class FacadeInterface
 * @see \Afip\ServiceCaller
 * @method mixed getPersona
 */
class AfipPadronA4 extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'ws_sr_padron_a4';
    }
}