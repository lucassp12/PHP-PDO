<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4505f72c6d8487b7e56a848722104ba6
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4505f72c6d8487b7e56a848722104ba6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4505f72c6d8487b7e56a848722104ba6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4505f72c6d8487b7e56a848722104ba6::$classMap;

        }, null, ClassLoader::class);
    }
}