<?php

    namespace Bedoya\HasData\Tests;

    use Bedoya\HasData\HasDataServiceProvider;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Orchestra\Testbench\TestCase as BaseTestCase;

    abstract class TestCase extends BaseTestCase
    {
        use RefreshDatabase;

        /**
         * @return void
         */
        protected function defineDatabaseMigrations(): void
        {
            $this->loadMigrationsFrom( realpath( __DIR__ . '/Database/migrations' ) );
        }

        /**
         * Configure the tests to use SQLite in memory
         *
         * @param $app
         *
         * @return void
         */
        protected function getEnvironmentSetUp( $app ): void
        {
            $app[ 'config' ]->set( 'database.default', 'sqlite' );

            $app[ 'config' ]->set( 'database.connections.sqlite', [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ] );
        }

        /**
         * Package provider
         *
         * @param $app
         *
         * @return string[]
         */
        protected function getPackageProviders( $app ): array
        {
            return [
                HasDataServiceProvider::class,
            ];
        }
    }
