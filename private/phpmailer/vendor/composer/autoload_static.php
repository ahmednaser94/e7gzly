<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc34d534aeffffb3a279e01e4e27bbf1c
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc34d534aeffffb3a279e01e4e27bbf1c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc34d534aeffffb3a279e01e4e27bbf1c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
