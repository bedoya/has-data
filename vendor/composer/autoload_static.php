<?php

// autoload_static.php @generated by Composer

    namespace Composer\Autoload;

    class ComposerStaticInit1ba5e25d60b605bbb996084f53c3c34d {
        public static $prefixLengthsPsr4 = [
            'B' =>
                [
                    'Bedoya\\HasData\\' => 15,
                ],
        ];

        public static $prefixDirsPsr4 = [
            'Bedoya\\HasData\\' =>
                [
                    0 => __DIR__ . '/../..' . '/src',
                ],
        ];

        public static $classMap = [
            'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        ];

        public static function getInitializer( ClassLoader $loader )
        {
            return \Closure::bind( function() use ( $loader ){
                $loader->prefixLengthsPsr4 = ComposerStaticInit1ba5e25d60b605bbb996084f53c3c34d::$prefixLengthsPsr4;
                $loader->prefixDirsPsr4 = ComposerStaticInit1ba5e25d60b605bbb996084f53c3c34d::$prefixDirsPsr4;
                $loader->classMap = ComposerStaticInit1ba5e25d60b605bbb996084f53c3c34d::$classMap;

            }, null, ClassLoader::class );
        }
    }