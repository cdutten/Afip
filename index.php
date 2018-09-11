<?php

require __DIR__ . '/vendor/autoload.php';

use Afip\Dummy;
use Afip\padronA4;
use Dotenv\Dotenv;

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

$auth = new \Afip\Authenticator('storage/keys/TA.xml');
var_dump($auth->getCredentials());
