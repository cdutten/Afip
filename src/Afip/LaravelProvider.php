<?php

namespace Afip;

use Illuminate\Support\ServiceProvider;


class LaravelProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('Afip', function ($app) {
            $afip = config('app.afip');
            $service = $afip['service'];
            $wsaaClient = new WSAAClient($service, $afip['path'], $afip['url'], $afip['passphrare'], $afip['host'], $afip['port']);
            $auth = new Authenticator($service, $wsaaClient);
            return new \Afip\ServiceCaller($service, $auth);
        });
    }
}