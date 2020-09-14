<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8041eb55433c5919211a56d28db1a693
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'l' => 
        array (
            'libphonenumber\\' => 15,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
        ),
        'O' => 
        array (
            'Opis\\JsonSchema\\' => 16,
            'OpisErrorPresenter\\' => 19,
        ),
        'G' => 
        array (
            'Giggsey\\Locale\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'libphonenumber\\' => 
        array (
            0 => __DIR__ . '/..' . '/giggsey/libphonenumber-for-php/src',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Opis\\JsonSchema\\' => 
        array (
            0 => __DIR__ . '/..' . '/opis/json-schema/src',
        ),
        'OpisErrorPresenter\\' => 
        array (
            0 => __DIR__ . '/..' . '/m1x0n/opis-json-schema-error-presenter/src',
        ),
        'Giggsey\\Locale\\' => 
        array (
            0 => __DIR__ . '/..' . '/giggsey/locale/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8041eb55433c5919211a56d28db1a693::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8041eb55433c5919211a56d28db1a693::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}