<?php
/**
 * Created by PhpStorm.
 * User: cdutten
 * Date: 12/08/18
 * Time: 23:01
 */

namespace Afip;


class padronA4
{
    public function getPerson($service, $params) {
        $params = simplexml_load_file(__DIR__ . "/../../consulta.xml");
        $client = new \SoapClient($service);
        return $client->getPersona(
            array(
                'token' =>  'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/Pgo8c3NvIHZlcnNpb249IjIuMCI+CiAgICA8aWQgc3JjPSJDTj13c2FhaG9tbywgTz1BRklQLCBDPUFSLCBTRVJJQUxOVU1CRVI9Q1VJVCAzMzY5MzQ1MDIzOSIgdW5pcXVlX2lkPSIxODA1MjA3ODM1IiBnZW5fdGltZT0iMTUzNDEyMjg1NSIgZXhwX3RpbWU9IjE1MzQxNjYxMTUiLz4KICAgIDxvcGVyYXRpb24gdHlwZT0ibG9naW4iIHZhbHVlPSJncmFudGVkIj4KICAgICAgICA8bG9naW4gZW50aXR5PSIzMzY5MzQ1MDIzOSIgc2VydmljZT0id3Nfc3JfcGFkcm9uX2E0IiB1aWQ9IlNFUklBTE5VTUJFUj1DVUlUIDIwNDA4Mzg0MzU1LCBDTj10ZXN0IiBhdXRobWV0aG9kPSJjbXMiIHJlZ21ldGhvZD0iMjIiPgogICAgICAgICAgICA8cmVsYXRpb25zPgogICAgICAgICAgICAgICAgPHJlbGF0aW9uIGtleT0iMjA0MDgzODQzNTUiIHJlbHR5cGU9IjQiLz4KICAgICAgICAgICAgPC9yZWxhdGlvbnM+CiAgICAgICAgPC9sb2dpbj4KICAgIDwvb3BlcmF0aW9uPgo8L3Nzbz4K',
                'sign' => 'X9bEhQkLHMCFslcCfa8yZ81tmAe6FZL7T51b7JGGFOccxjzYLzhasxLuG8lxWZMuQwPf1Xl6UYRL+2GTeMpsVC0b2h9fUOffVR3FppohSOQEv7OHBdr4txDBbldrqYsQb2obLaj85lMUVKY/OPJHR8zHOFYLHs18vSmiFaLNgbQ=',
                'cuitRepresentada' => '20408384355',
                'idPersona' => '20000000516'
            )
        );
    }
}