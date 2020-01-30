<?php

namespace Assetku\DigitalSignature\Providers;

use Assetku\DigitalSignature\DigitalSignatureService;
use Assetku\DigitalSignature\Driver;
use Illuminate\Support\ServiceProvider;

class DigitalSignatureServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // merge package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/digital-signature.php', 'digital-signature');

        // register a driver binding with the container.
        $this->app->bind('assetkita.digital_signature_driver', function () {
            return new Driver(config('digital-signature.default'));
        });

        // Register a facade shared binding in the container.
        $this->app->singleton('assetkita.digital_signature', function () {
            return new DigitalSignatureService;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // publish package configuration
        $this->publishes([
            __DIR__.'/../config/digital-signature.php' => config_path('digital-signature.php'),
        ], 'config');

        // publish package views
        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/digital-signature'),
        ], 'views');
    }
}
