<?php

namespace Afip\Validators;

use Afip\Authenticator;
use Afip\Exception;
use Afip\ServiceCaller;
use Afip\WSAAClient;

class DNIValidator
{
    const CUIT_TYPES = [
        "M" => [20, 23, 24],
        "F" => [27, 23, 24]
    ];


    /**
     * Try to validate a DNI with the ws_sr_padron_a4 service
     *
     * @param integer $dni
     * @param string $gender
     *
     * @return bool
     * @throws \Afip\Exception
     */
    public static function validateDNI($dni, $gender)
    {
        $possibleCuits = self::calculatePossibleCuits($dni, DNIValidator::CUIT_TYPES[$gender]);
        if (! $possibleCuits) {
            throw new Exception('No possible cuit for the DNI');
        }
        foreach ($possibleCuits as $cuit) {
            $wsaaClient = new WSAAClient('ws_sr_padron_a4', __DIR__ . '/../../../secret/ws_sr_padron_a4/');
            $auth = new Authenticator(__DIR__ . '/../../../secret/ws_sr_padron_a4/', $wsaaClient);
            $service = new ServiceCaller(
                "https://awshomo.afip.gov.ar/sr-padron/webservices/personaServiceA4?WSDL",
                $auth
            );
            try {
                return $service->getPersona(['idPersona' => $cuit]);
            } catch (\SoapFault $e) {
                continue;
            }
        }
    }

    /**
     * Calculate the possibles cuits by the dni
     *
     * @param $dni
     * @param $types
     *
     * @return array
     */
    public static function calculatePossibleCuits($dni, $types)
    {
        $possibleCuit = [];
        foreach ($types as $type) {
            $possibleNumber = $type . $dni;
            $accumulated = 0;
            $digits = str_split($possibleNumber);
            for ($i = 0; $i < count($digits); $i++) {
                $accumulated += $digits[ 9 - $i ] * (2 + ($i % 6));
            }
            $verifier = 11 - ($accumulated % 11);
            $verifier = $verifier == 11? 0 : $verifier;
            $possibleCuit[] = $possibleNumber . $verifier;
        }
        return $possibleCuit;
    }
}