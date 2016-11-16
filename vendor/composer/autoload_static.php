<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit024480c1ce9453f583fdb4349ca342bd
{
    public static $prefixLengthsPsr4 = array (
        'Z' => 
        array (
            'Zend\\Stdlib\\' => 12,
            'Zend\\Db\\' => 8,
        ),
        'Q' => 
        array (
            'Queue\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Zend\\Stdlib\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-stdlib/src',
        ),
        'Zend\\Db\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-db/src',
        ),
        'Queue\\' => 
        array (
            0 => __DIR__ . '/../..' . '/fsqueue',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit024480c1ce9453f583fdb4349ca342bd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit024480c1ce9453f583fdb4349ca342bd::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
