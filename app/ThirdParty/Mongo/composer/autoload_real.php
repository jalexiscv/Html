<?php

class ComposerAutoloaderInit6e6b261bf2b849d24a3e518799df0f3f
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }
        require __DIR__ . '/platform_check.php';
        spl_autoload_register(array('ComposerAutoloaderInit6e6b261bf2b849d24a3e518799df0f3f', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit6e6b261bf2b849d24a3e518799df0f3f', 'loadClassLoader'));
        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit6e6b261bf2b849d24a3e518799df0f3f::getInitializer($loader));
        $loader->register(true);
        $includeFiles = \Composer\Autoload\ComposerStaticInit6e6b261bf2b849d24a3e518799df0f3f::$files;
        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequire6e6b261bf2b849d24a3e518799df0f3f($fileIdentifier, $file);
        }
        return $loader;
    }
}

function composerRequire6e6b261bf2b849d24a3e518799df0f3f($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;
        require $file;
    }
}