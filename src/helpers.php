<?php

    use Illuminate\Container\Container;

    if ( !function_exists( 'config_path' ) ) {
        /**
         * Get the path to the configuration directory.
         *
         * @param string $path
         *
         * @return string
         */
        function config_path ( string $path = '' ): string
        {
            return Container::getInstance()->basePath( 'config' ) . ( $path ? DIRECTORY_SEPARATOR . $path : '' );
        }
    }
