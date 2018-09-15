##  Collaborators

* [cdutten](https://github.com/cdutten)
* [megui88](https://github.com/megui88)



[Lectura necesaria](http://www.afip.gob.ar/ws/paso4.asp)

[CUIT para pruebas](http://www.afip.gob.ar/ws/ws_sr_padron_a4/datos-prueba-padron-a4.txt)

Es importante que los archivos `key` y `crt` posean el mismo nombre que el servicio a consumir.
Por ejemplo si desea consumir el servicio de `padron-a4` los archivos debén llamarse: `ws_sr_padron_a4.crt` y `ws_sr_padron_a4.key`. 
Tambien se recomienda que esten en una subcarpeta llamada como el servicio:
```
./secret
   |_ ws_sr_padron_a4
        |_ws_sr_padron_a4.crt
        |_ws_sr_padron_a4.key
```
De esta forma podra disponer de distintos certificados para distintos servicios.

###### Es importante que PHP tenga permisos de escritura sobre dicha carpeta.

### PHP Nativo

##### crear el archivo get-persona.php

Ejemplo configurado para AFIP en modo prueba **homo**

```
$path = $1;
$cuit = $2;
$service = 'ws_sr_padron_a4';
$url = 'https://wsaahomo.afip.gov.ar/ws/services/LoginCms?wsdl';
$passphrare = 'xxxxx';
$host = '10.20.152.112';
$port = '80';
$wsaa = new WSAAClient($service, $path, $url, $passphrare, $host, $port);
$auth = new Authenticator($service, $wsaa);
$service= new ServiceCaller($service, $auth);
$service->getPersona($cuit);
```
#### Uso:

```
php ./get-persona.php $PWD/secret/ws_sr_padron_a4/ 20002307554 
```

### Laravel

composer require cdutten/Afip

##### .env
```
//Esta carpeta puede estar fuera del sistema para su proteccion
AFIP_KEY_PATH=~/secret-keys 
```

##### config/afip.php
```
retrun [
   'path' => env('AFIP_KEY_PATH', storage_path('/secret')),
   'url' => env('AFIP_URL', 'https://wsaahomo.afip.gov.ar'),
   'passphrare' => env('AFIP_PASSPHRARE', 'xxxxx'),
   'host' => env('AFIP_PROXY_HOST', '10.20.152.112'),
   'port' => env('AFIP_PROXY_PORT', '80'),
]
```

##### config/app.php
```
'providers' => [
   ...
   \Afip\Providers\Laravel\AfipPadronA4::class
]
```

#### Uso:
```
AfipPadronA4::getPersona('20002307554');
```

## Dev

Se require docker (instalación: [Ubuntu](https://docs.docker.com/install/linux/docker-ce/ubuntu/), [Mac](https://docs.docker.com/docker-for-mac/install/)) y docker-compose (instalación: [Ubuntu](https://docs.docker.com/compose/install/)) para el desarrollo sobre esta libreria.

Ejecución:

```
~local$: git clone git@github.com:cdutten/Afip.git
~local$: cd Afip
~local$: cp [Carpeta donde tengo el crt y key] ./secret/ws_sr_padron_a4
~local$: docker-compose up -d
~local$: docker-compose exec afip bash
~docker-afip$ composer install
~docker-afip$ ./vendor/bin/phpunit test
~docker-afip$ get-persona.php $PWD/secret/ws_sr_padron_a4 tuCuit
```



