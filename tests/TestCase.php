<?php

    namespace Bedoya\HasData\Tests;

    use Orchestra\Testbench\TestCase as BaseTestCase;
    use Bedoya\HasData\HasDataServiceProvider;

    abstract class TestCase extends BaseTestCase
    {
        /**
         * Configure the tests to use SQLite in memory
         *
         * @param $app
         *
         * @return void
         */
        protected function getEnvironmentSetUp($app): void
        {
            $app['config']->set('database.default', 'sqlite');
            $app['config']->set('database.connections.sqlite', [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]);
        }

        /**
         * Package provider
         *
         * @param $app
         *
         * @return string[]
         */
        protected function getPackageProviders ( $app ): array
        {
            return [
                HasDataServiceProvider::class,
            ];
        }
    }
