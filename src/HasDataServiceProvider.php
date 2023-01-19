<?php

    namespace Bedoya\HasData;

    use Illuminate\Support\ServiceProvider;

    class HasDataServiceProvider extends ServiceProvider {
        /**
         * Bootstrap HasData services.
         *
         * @return void
         */
        public function boot(): void
        {
            if( $this->app->runningInConsole() ){
                $this->publishes(
                    [
                        __DIR__ . '/../config/has-data.php' => config_path( 'has-data.php' ),
                    ],
                    'config'
                );
            }
        }

        /**
         * Register HasData services.
         *
         * @return void
         */
        public function register(): void
        {
            $this->mergeConfigFrom( __DIR__ . '/../config/has-data.php', 'has-data' );
        }
    }
