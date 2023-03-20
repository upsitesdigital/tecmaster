<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit5f1d609742322312022bb283b3f856da
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Google_Web_Stories_Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Google_Web_Stories_Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit5f1d609742322312022bb283b3f856da', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Google_Web_Stories_Composer\Autoload\ClassLoader(\dirname(\dirname(__FILE__)));
        spl_autoload_unregister(array('ComposerAutoloaderInit5f1d609742322312022bb283b3f856da', 'loadClassLoader'));

        $useStaticLoader = PHP_VERSION_ID >= 50600 && !defined('HHVM_VERSION') && (!function_exists('zend_loader_file_encoded') || !zend_loader_file_encoded());
        if ($useStaticLoader) {
            require __DIR__ . '/autoload_static.php';

            call_user_func(\Google_Web_Stories_Composer\Autoload\ComposerStaticInit5f1d609742322312022bb283b3f856da::getInitializer($loader));
        } else {
            $classMap = require __DIR__ . '/autoload_classmap.php';
            if ($classMap) {
                $loader->addClassMap($classMap);
            }
        }

        $loader->setClassMapAuthoritative(true);
        $loader->register(true);

        return $loader;
    }
}