<?php

namespace Afip\Providers\Laravel;

use Afip\Providers\Laravel\Support\Facades\AfipPadronA4;

/**
 * Class PadronA4Provider
 * @package Afip\Providers\Laravel
 */
class PadronA4Provider extends LaravelProvider
{

    /**
     * @return string
     */
    public function getWsdlService()
    {
        return 'ws_sr_padron_a4';
    }

    /**
     * @return string
     */
    public function getWsdlServicePath()
    {
        return '/sr-padron/webservices/personaServiceA4?WSDL';
    }

    /**
     * @return string
     */
    public function getFacadesName()
    {
        return 'AfipPadronA4';
    }

    /**
     * @return string
     */
    public function getFacadesClass()
    {
        return AfipPadronA4::class;
    }
}