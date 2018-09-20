<?php

namespace Afip\Providers\Laravel;

/**
 * Interface AfipLaravelProvidersInteraface
 * @package Afip\Providers\Laravel
 */
interface AfipLaravelProvidersInteraface
{
    /** return string */
    public function getWsdlService();

    /** return string */
    public function getFacadesName();

    /** return string */
    public function getFacadesClass();

    /** return string */
    public function getWsdlServicePath();
}