<?php

namespace Assetku\DigitalSignature\tests;

use Assetku\DigitalSignature\Facades\DigitalSignatureFacade;
use Assetku\DigitalSignature\Providers\DigitalSignatureServiceProvider;
use Faker\Factory;
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
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            DigitalSignatureServiceProvider::class
        ];
    }

    /**
     * Load package alias
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'DigitalSignature' => DigitalSignatureFacade::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app->useEnvironmentPath(__DIR__ . '/../')
            ->loadEnvironmentFrom('.env.testing')
            ->bootstrapWith([
                LoadEnvironmentVariables::class
            ]);

        $app['config']->set('digital-signature.default', env('DIGITAL_SIGNATURE_DRIVER'));

        $app['config']->set('digital-signature.services.privy', [
            'merchant_key'     => env('PRIVY_MERCHANT_KEY'),
            'username'         => env('PRIVY_USERNAME'),
            'password'         => env('PRIVY_PASSWORD'),
            'endpoint'         => [
                'development' => env('PRIVY_ENDPOINT_DEVELOPMENT'),
                'production'  => env('PRIVY_ENDPOINT_PRODUCTION')
            ],
            'enterprise_token' => [
                'development' => env('PRIVY_ENTERPRISE_TOKEN_DEVELOPMENT'),
                'production'  => env('PRIVY_ENTERPRISE_TOKEN_PRODUCTION')
            ]
        ]);
    }
}
