<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit264187e6723a24ac7eacc81d3f0a8b3c
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

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit264187e6723a24ac7eacc81d3f0a8b3c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit264187e6723a24ac7eacc81d3f0a8b3c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
