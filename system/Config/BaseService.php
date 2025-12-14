<?php

namespace Higgs\Config;

use Higgs\Autoloader\Autoloader;
use Higgs\Autoloader\FileLocator;
use Higgs\Cache\CacheInterface;
use Higgs\CLI\Commands;
use Higgs\Higgs;
use Higgs\Database\ConnectionInterface;
use Higgs\Database\MigrationRunner;
use Higgs\Debug\Exceptions;
use Higgs\Debug\Iterator;
use Higgs\Debug\Timer;
use Higgs\Debug\Toolbar;
use Higgs\Email\Email;
use Higgs\Encryption\EncrypterInterface;
use Higgs\Filters\Filters;
use Higgs\Format\Format;
use Higgs\Honeypot\Honeypot;
use Higgs\HTTP\CLIRequest;
use Higgs\HTTP\ContentSecurityPolicy;
use Higgs\HTTP\CURLRequest;
use Higgs\HTTP\IncomingRequest;
use Higgs\HTTP\Negotiate;
use Higgs\HTTP\RedirectResponse;
use Higgs\HTTP\Request;
use Higgs\HTTP\RequestInterface;
use Higgs\HTTP\ResponseInterface;
use Higgs\HTTP\URI;
use Higgs\Images\Handlers\BaseHandler;
use Higgs\Language\Language;
use Higgs\Log\Logger;
use Higgs\Pager\Pager;
use Higgs\Router\RouteCollection;
use Higgs\Router\RouteCollectionInterface;
use Higgs\Router\Router;
use Higgs\Security\Security;
use Higgs\Session\Session;
use Higgs\Throttle\Throttler;
use Higgs\Typography\Typography;
use Higgs\Validation\ValidationInterface;
use Higgs\View\Cell;
use Higgs\View\Parser;
use Higgs\View\RendererInterface;
use Higgs\View\View;
use Config\App;
use Config\Autoload;
use Config\Cache;
use Config\ContentSecurityPolicy as CSPConfig;
use Config\Encryption;
use Config\Exceptions as ConfigExceptions;
use Config\Filters as ConfigFilters;
use Config\Format as ConfigFormat;
use Config\Honeypot as ConfigHoneyPot;
use Config\Images;
use Config\Migrations;
use Config\Modules;
use Config\Pager as ConfigPager;
use Config\Services as AppServices;
use Config\Toolbar as ConfigToolbar;
use Config\Validation as ConfigValidation;
use Config\View as ConfigView;

class BaseService
{
    protected static $instances = [];
    protected static $mocks = [];
    protected static $discovered = false;
    protected static $services = [];
    private static array $serviceNames = [];

    public static function __callStatic(string $name, array $arguments)
    {
        $service = static::serviceExists($name);
        if ($service === null) {
            return null;
        }
        return $service::$name(...$arguments);
    }

    public static function serviceExists(string $name): ?string
    {
        static::buildServicesCache();
        $services = array_merge(self::$serviceNames, [Services::class]);
        $name = strtolower($name);
        foreach ($services as $service) {
            if (method_exists($service, $name)) {
                return $service;
            }
        }
        return null;
    }

    protected static function buildServicesCache(): void
    {
        if (!static::$discovered) {
            $config = config('Modules');
            if ($config->shouldDiscover('services')) {
                $locator = static::locator();
                $files = $locator->search('Config/Services');
                foreach ($files as $file) {
                    $classname = $locator->getClassname($file);
                    if ($classname !== Services::class) {
                        self::$serviceNames[] = $classname;
                        static::$services[] = new $classname();
                    }
                }
            }
            static::$discovered = true;
        }
    }

    public static function locator(bool $getShared = true)
    {
        if ($getShared) {
            if (empty(static::$instances['locator'])) {
                static::$instances['locator'] = new FileLocator(static::autoloader());
            }
            return static::$mocks['locator'] ?? static::$instances['locator'];
        }
        return new FileLocator(static::autoloader());
    }

    public static function autoloader(bool $getShared = true)
    {
        if ($getShared) {
            if (empty(static::$instances['autoloader'])) {
                static::$instances['autoloader'] = new Autoloader();
            }
            return static::$instances['autoloader'];
        }
        return new Autoloader();
    }

    public static function reset(bool $initAutoloader = true)
    {
        static::$mocks = [];
        static::$instances = [];
        if ($initAutoloader) {
            static::autoloader()->initialize(new Autoload(), new Modules());
        }
    }

    public static function resetSingle(string $name)
    {
        $name = strtolower($name);
        unset(static::$mocks[$name], static::$instances[$name]);
    }

    public static function injectMock(string $name, $mock)
    {
        static::$mocks[strtolower($name)] = $mock;
    }

    protected static function getSharedInstance(string $key, ...$params)
    {
        $key = strtolower($key);
        if (isset(static::$mocks[$key])) {
            return static::$mocks[$key];
        }
        if (!isset(static::$instances[$key])) {
            $params[] = false;
            static::$instances[$key] = AppServices::$key(...$params);
        }
        return static::$instances[$key];
    }

    protected static function discoverServices(string $name, array $arguments)
    {
        if (!static::$discovered) {
            $config = config('Modules');
            if ($config->shouldDiscover('services')) {
                $locator = static::locator();
                $files = $locator->search('Config/Services');
                if (empty($files)) {
                    return null;
                }
                foreach ($files as $file) {
                    $classname = $locator->getClassname($file);
                    if (!in_array($classname, [Services::class], true)) {
                        static::$services[] = new $classname();
                    }
                }
            }
            static::$discovered = true;
        }
        if (!static::$services) {
            return null;
        }
        foreach (static::$services as $class) {
            if (method_exists($class, $name)) {
                return $class::$name(...$arguments);
            }
        }
        return null;
    }
}