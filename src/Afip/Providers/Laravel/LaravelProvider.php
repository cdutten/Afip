<?php

namespace Afip\Providers\Laravel;

use Afip\Authenticator;
use Afip\Providers\Laravel\Support\Facades\FacadeInterface;
use Afip\ServiceCaller;
use Afip\WSAAClient;
use Illuminate\Support\ServiceProvider;

/**
 * Class LaravelProvider
 * @package FacadeInterface\Providers\Laravel
 */
abstract class LaravelProvider extends ServiceProvider implements AfipLaravelProvidersInteraface
{

    public function register()
    {
        $service = $this->getWsdlService();
        $this->app->singleton($service, function ($app) use ($service) {
            $afip = config('app.afip');
            $path = $afip['path'] . '/' . $service;
            $wsaaClient = new WSAAClient($service, $path, $afip['url'], $afip['passphrare'], $afip['host'], $afip['port']);
            $auth = new Authenticator($service, $wsaaClient);
            $url = $afip['url'] . $this->getWsdlServicePath();
            return new ServiceCaller($url, $auth);
        });

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias($this->getFacadesName(), $this->getFacadesClass());
    }
}