<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3c1535d51e1b024c5e61b99b529d4930
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'Util\\Command\\' => 13,
            'Util\\' => 5,
        ),
        'D' => 
        array (
            'Doctrine\\Common\\Inflector\\' => 26,
            'Doctrine\\Common\\Cache\\' => 22,
            'Doctrine\\Common\\Annotations\\' => 28,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Util\\Command\\' => 
        array (
            0 => __DIR__ . '/../..' . '/cmd',
        ),
        'Util\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Doctrine\\Common\\Inflector\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/inflector/lib/Doctrine/Common/Inflector',
        ),
        'Doctrine\\Common\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/cache/lib/Doctrine/Common/Cache',
        ),
        'Doctrine\\Common\\Annotations\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/annotations/lib/Doctrine/Common/Annotations',
        ),
    );

    public static $prefixesPsr0 = array (
        'D' => 
        array (
            'Doctrine\\DBAL\\' => 
            array (
                0 => __DIR__ . '/..' . '/doctrine/dbal/lib',
            ),
            'Doctrine\\Common\\Lexer\\' => 
            array (
                0 => __DIR__ . '/..' . '/doctrine/lexer/lib',
            ),
            'Doctrine\\Common\\Collections\\' => 
            array (
                0 => __DIR__ . '/..' . '/doctrine/collections/lib',
            ),
            'Doctrine\\Common\\' => 
            array (
                0 => __DIR__ . '/..' . '/doctrine/common/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3c1535d51e1b024c5e61b99b529d4930::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3c1535d51e1b024c5e61b99b529d4930::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit3c1535d51e1b024c5e61b99b529d4930::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
