<?php

    namespace Bedoya\HasData\Tests;

    use Orchestra\Testbench\TestCase as BaseTestCase;
    use Bedoya\HasData\HasDataServiceProvider;

    abstract class TestCase extends BaseTestCase
    {
        protected function getPackageProviders ( $app ): array
        {
            return [
                HasDataServiceProvider::class,
            ];
        }
    }
