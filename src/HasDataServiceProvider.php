<?php

    namespace Bedoya\HasData;

    use Illuminate\Support\ServiceProvider;

    class HasDataServiceProvider extends ServiceProvider
    {
        /**
         * Register bindings in the container.
         */
        public function register(): void
        {
            $this->mergeConfigFrom( __DIR__ . '/../config/has-data.php', 'has-data' );
        }

        /**
         * Perform post-registration booting of services.
         */
        public function boot (): void
        {
            if ( $this->app->runningInConsole() ) {
                $this->publishes( [
                    $this->packageConfigPath() => $this->laravelConfigPath(),
                ], 'has-data-config' );
            }
        }

        /**
         * Local path to the package's configuration file
         *
         * @return string
         */
        protected function packageConfigPath(): string
        {
            return __DIR__ . '/../config/has-data.php';
        }

        /**
         * Path to the configuration directory in the Laravel application.
         * This replaces `config_path()`, which may not exist in standalone packages.
         *
         * @return string
         */
        protected function laravelConfigPath(): string
        {
            return $this->app->configPath('has-data.php');
        }
    }
