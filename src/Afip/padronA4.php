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
        $client = new \SoapClient($service);
        return $client->getPersona(
            array(
                'token' =>  'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/Pgo8c3NvIHZlcnNpb249IjIuMCI+CiAgICA8aWQgc3JjPSJDTj13c2FhaG9tbywgTz1BRklQLCBDPUFSLCBTRVJJQUxOVU1CRVI9Q1VJVCAzMzY5MzQ1MDIzOSIgdW5pcXVlX2lkPSIzNTA1MzkwNDQ1IiBnZW5fdGltZT0iMTUzNDE4Njc1NyIgZXhwX3RpbWU9IjE1MzQyMzAwMTciLz4KICAgIDxvcGVyYXRpb24gdHlwZT0ibG9naW4iIHZhbHVlPSJncmFudGVkIj4KICAgICAgICA8bG9naW4gZW50aXR5PSIzMzY5MzQ1MDIzOSIgc2VydmljZT0id3Nfc3JfcGFkcm9uX2E0IiB1aWQ9IlNFUklBTE5VTUJFUj1DVUlUIDIwNDA4Mzg0MzU1LCBDTj10ZXN0ZXh0ZW5kZWFsIiBhdXRobWV0aG9kPSJjbXMiIHJlZ21ldGhvZD0iMjIiPgogICAgICAgICAgICA8cmVsYXRpb25zPgogICAgICAgICAgICAgICAgPHJlbGF0aW9uIGtleT0iMjA0MDgzODQzNTUiIHJlbHR5cGU9IjQiLz4KICAgICAgICAgICAgPC9yZWxhdGlvbnM+CiAgICAgICAgPC9sb2dpbj4KICAgIDwvb3BlcmF0aW9uPgo8L3Nzbz4K',
                'sign' => 'sOnDYc9dadx7Nb1CpxmZ0Tl17rA9DwBXjbFYkgwzjderSX3ZNVyRKAZ8zWogMXTbG87O76Twi2pMfYfBbjyXmGJpKyMGbHxC2CCJDXViYeZY7toDl2doUcFOpDyNQ2tN1zkxdmJQSvj6RhNO6Ln/0ia4SpX3nFDS/OKkmb/Ii00=',
                'cuitRepresentada' => '20408384355',
                'idPersona' => '20000000516'
            )
        );
    }
}