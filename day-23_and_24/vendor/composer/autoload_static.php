<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1d9324ca3108cf888d54e448e1737574
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Sinopac\\QPay\\' => 13,
            'Sinopac\\' => 8,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Sinopac\\QPay\\' => 
        array (
            0 => __DIR__ . '/..' . '/terrylinooo/sinopac-php-sdk/src/QPay',
        ),
        'Sinopac\\' => 
        array (
            0 => __DIR__ . '/..' . '/terrylinooo/sinopac-php-sdk/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1d9324ca3108cf888d54e448e1737574::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1d9324ca3108cf888d54e448e1737574::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1d9324ca3108cf888d54e448e1737574::$classMap;

        }, null, ClassLoader::class);
    }
}