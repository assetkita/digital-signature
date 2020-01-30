<?php

namespace Assetku\DigitalSignature\Tests;

use Faker\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * @var Factory
     */
    protected $faker;

    /**
     * TestCase constructor.
     *
     * @param  null  $name
     * @param  array  $data
     * @param  string  $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->faker = Factory::create('id_ID');
    }

    /**
     * Load package service provider
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Assetku\DigitalSignature\Providers\DigitalSignatureServiceProvider::class
        ];
    }

    /**
     * Load package alias
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'DigitalSignature' => \Assetku\DigitalSignature\Facades\DigitalSignature::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app->useEnvironmentPath(__DIR__.'/../digital-signature')
            ->loadEnvironmentFrom('.env.testing')
            ->bootstrapWith([
                LoadEnvironmentVariables::class
            ]);

        $app['config']->set('digital-signature.default', env('DIGITAL_SIGNATURE_DRIVER'));

        $app['config']->set('digital-signature.services.privy', [
            'merchant_key' => env('PRIVY_MERCHANT_KEY'),
            'username'     => env('PRIVY_USERNAME'),
            'password'     => env('PRIVY_PASSWORD'),
            'development'  => [
                'endpoint'         => env('PRIVY_DEVELOPMENT_ENDPOINT'),
                'enterprise_token' => env('PRIVY_DEVELOPMENT_ENTERPRISE_TOKEN'),
            ],
            'production'   => [
                'endpoint'         => env('PRIVY_PRODUCTION_ENDPOINT'),
                'enterprise_token' => env('PRIVY_PRODUCTION_ENTERPRISE_TOKEN'),
            ],
        ]);
    }
}
