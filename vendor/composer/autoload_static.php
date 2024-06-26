<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbc52088dd34965a20b1bdf58f3ddc129
{
    public static $files = array (
        '257db1d61e8957aea30e88ffe6302f01' => __DIR__ . '/../..' . '/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Dboyz\\PS\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Dboyz\\PS\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbc52088dd34965a20b1bdf58f3ddc129::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbc52088dd34965a20b1bdf58f3ddc129::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbc52088dd34965a20b1bdf58f3ddc129::$classMap;

        }, null, ClassLoader::class);
    }
}
