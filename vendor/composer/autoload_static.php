<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitda5cbe122fed80cc158f0d8ab4bf3b6b
{
    public static $prefixLengthsPsr4 = array (
        'Z' => 
        array (
            'Zend\\Escaper\\' => 13,
        ),
        'P' => 
        array (
            'Psr\\SimpleCache\\' => 16,
            'PhpOffice\\PhpWord\\' => 18,
            'PhpOffice\\PhpSpreadsheet\\' => 25,
            'PhpOffice\\Common\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Zend\\Escaper\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-escaper/src',
        ),
        'Psr\\SimpleCache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/simple-cache/src',
        ),
        'PhpOffice\\PhpWord\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/phpword/src/PhpWord',
        ),
        'PhpOffice\\PhpSpreadsheet\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/phpspreadsheet/src/PhpSpreadsheet',
        ),
        'PhpOffice\\Common\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/common/src/Common',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'PHPExcel' => 
            array (
                0 => __DIR__ . '/..' . '/phpoffice/phpexcel/Classes',
            ),
        ),
    );

    public static $classMap = array (
        'PclZip' => __DIR__ . '/..' . '/pclzip/pclzip/pclzip.lib.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitda5cbe122fed80cc158f0d8ab4bf3b6b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitda5cbe122fed80cc158f0d8ab4bf3b6b::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitda5cbe122fed80cc158f0d8ab4bf3b6b::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitda5cbe122fed80cc158f0d8ab4bf3b6b::$classMap;

        }, null, ClassLoader::class);
    }
}
