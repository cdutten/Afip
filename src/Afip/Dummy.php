<?php
/**
 * Created by PhpStorm.
 * User: cdutten
 * Date: 12/08/18
 * Time: 22:42
 */

namespace Afip;


class Dummy
{
    /**
     * Check the dummy method of the service
     *
     * @param string $service
     * @param array $params
     * @return mixed
     */
    public static function check ($service, $params) {
        $client = new \SoapClient($service, $params);
        return $client->dummy($params);//llamamos al métdo que nos interesa con los parámetros
    }
}