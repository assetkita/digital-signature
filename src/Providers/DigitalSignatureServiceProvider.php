<?php

namespace Assetku\DigitalSignature\Providers;

use Assetku\DigitalSignature\Contracts\DigitalSignature as DigitalSignatureContract;
use Assetku\DigitalSignature\DigitalSignature;
use Assetku\DigitalSignature\Exceptions\DigitalSignatureDriverException;
use Assetku\DigitalSignature\Services\Privy;
use Illuminate\Support\ServiceProvider;

class DigitalSignatureServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     * @throws \Assetku\DigitalSignature\Exceptions\DigitalSignatureDriverException
     */
    public function register()
    {
        // merge package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/digital-signature.php', 'digital-signature');

        // set digital signature
        switch (config('digital-signature.default')) {
            case 'privy':
                $digitalSignature = Privy::class;
                break;
            default:
                throw DigitalSignatureDriverException::unknownDriver();
                break;
        }

        // bind digital signature contract with digital signature concrete
        $this->app->bind(DigitalSignatureContract::class, $digitalSignature);

        // bind digital signature facade with digital signature instance
        $this->app->bind('assetkita.digital_signature', function () {
            return new DigitalSignature;
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
            __DIR__ . '/../config/digital-signature.php' => config_path('digital-signature.php')
        ], 'config');

        // publish package views
        $this->publishes([
            __DIR__ . '/../views' => resource_path('views/vendor/digital-signature')
        ], 'views');
    }
}
