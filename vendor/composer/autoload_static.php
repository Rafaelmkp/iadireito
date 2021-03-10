<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9f4a2508a62dc25de84425cc2521c873
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'IADireito\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'IADireito\\' => 
        array (
            0 => __DIR__ . '/..' . '/iadireito/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Slim' => 
            array (
                0 => __DIR__ . '/..' . '/slim/slim',
            ),
        ),
        'R' => 
        array (
            'Rain' => 
            array (
                0 => __DIR__ . '/..' . '/rain/raintpl/library',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9f4a2508a62dc25de84425cc2521c873::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9f4a2508a62dc25de84425cc2521c873::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit9f4a2508a62dc25de84425cc2521c873::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
