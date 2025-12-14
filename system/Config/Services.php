<?php

namespace Higgs\Config;

use Higgs\Cache\CacheFactory;
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
use Higgs\Encryption\Encryption;
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
use Higgs\HTTP\Response;
use Higgs\HTTP\ResponseInterface;
use Higgs\HTTP\URI;
use Higgs\HTTP\UserAgent;
use Higgs\Images\Handlers\BaseHandler;
use Higgs\Language\Language;
use Higgs\Log\Logger;
use Higgs\Pager\Pager;
use Higgs\Router\RouteCollection;
use Higgs\Router\RouteCollectionInterface;
use Higgs\Router\Router;
use Higgs\Security\Security;
use Higgs\Session\Handlers\Database\MySQLiHandler;
use Higgs\Session\Handlers\Database\PostgreHandler;
use Higgs\Session\Handlers\DatabaseHandler;
use Higgs\Session\Session;
use Higgs\Throttle\Throttler;
use Higgs\Typography\Typography;
use Higgs\Validation\Validation;
use Higgs\Validation\ValidationInterface;
use Higgs\View\Cell;
use Higgs\View\Parser;
use Higgs\View\RendererInterface;
use Higgs\View\View;
use Config\App;
use Config\Cache;
use Config\ContentSecurityPolicy as CSPConfig;
use Config\Database;
use Config\Email as EmailConfig;
use Config\Encryption as EncryptionConfig;
use Config\Exceptions as ExceptionsConfig;
use Config\Filters as FiltersConfig;
use Config\Format as FormatConfig;
use Config\Honeypot as HoneypotConfig;
use Config\Images;
use Config\Migrations;
use Config\Pager as PagerConfig;
use Config\Services as AppServices;
use Config\Session as SessionConfig;
use Config\Toolbar as ToolbarConfig;
use Config\Validation as ValidationConfig;
use Config\View as ViewConfig;
use Locale;

class Services extends BaseService
{
    public static function Higgs(?App $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('Higgs', $config);
        }
        $config ??= config('App');
        return new Higgs($config);
    }

    public static function commands(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('commands');
        }
        return new Commands();
    }

    public static function csp(?CSPConfig $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('csp', $config);
        }
        $config ??= config('ContentSecurityPolicy');
        return new ContentSecurityPolicy($config);
    }

    public static function curlrequest(array $options = [], ?ResponseInterface $response = null, ?App $config = null, bool $getShared = true)
    {
        if ($getShared === true) {
            return static::getSharedInstance('curlrequest', $options, $response, $config);
        }
        $config ??= config('App');
        $response ??= new Response($config);
        return new CURLRequest($config, new URI($options['base_uri'] ?? null), $response, $options);
    }

    public static function email($config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('email', $config);
        }
        if (empty($config) || !(is_array($config) || $config instanceof EmailConfig)) {
            $config = config('Email');
        }
        return new Email($config);
    }

    public static function encrypter(?EncryptionConfig $config = null, $getShared = false)
    {
        if ($getShared === true) {
            return static::getSharedInstance('encrypter', $config);
        }
        $config ??= config('Encryption');
        $encryption = new Encryption($config);
        return $encryption->initialize($config);
    }

    public static function exceptions(?ExceptionsConfig $config = null, ?IncomingRequest $request = null, ?ResponseInterface $response = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('exceptions', $config, $request, $response);
        }
        $config ??= config('Exceptions');
        $request ??= AppServices::request();
        $response ??= AppServices::response();
        return new Exceptions($config, $request, $response);
    }

    public static function request(?App $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('request', $config);
        }
        return static::incomingrequest($config, $getShared);
    }

    public static function incomingrequest(?App $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('request', $config);
        }
        $config ??= config('App');
        return new IncomingRequest($config, AppServices::uri(), 'php://input', new UserAgent());
    }

    public static function uri(?string $uri = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('uri', $uri);
        }
        return new URI($uri);
    }

    public static function response(?App $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('response', $config);
        }
        $config ??= config('App');
        return new Response($config);
    }

    public static function filters(?FiltersConfig $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('filters', $config);
        }
        $config ??= config('Filters');
        return new Filters($config, AppServices::request(), AppServices::response());
    }

    public static function format(?FormatConfig $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('format', $config);
        }
        $config ??= config('Format');
        return new Format($config);
    }

    public static function honeypot(?HoneypotConfig $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('honeypot', $config);
        }
        $config ??= config('Honeypot');
        return new Honeypot($config);
    }

    public static function image(?string $handler = null, ?Images $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('image', $handler, $config);
        }
        $config ??= config('Images');
        assert($config instanceof Images);
        $handler = $handler ?: $config->defaultHandler;
        $class = $config->handlers[$handler];
        return new $class($config);
    }

    public static function iterator(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('iterator');
        }
        return new Iterator();
    }

    public static function language(?string $locale = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('language', $locale)->setLocale($locale);
        }
        if (AppServices::request() instanceof IncomingRequest) {
            $requestLocale = AppServices::request()->getLocale();
        } else {
            $requestLocale = Locale::getDefault();
        }
        $locale = $locale ?: $requestLocale;
        return new Language($locale);
    }

    public static function migrations(?Migrations $config = null, ?ConnectionInterface $db = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('migrations', $config, $db);
        }
        $config ??= config('Migrations');
        return new MigrationRunner($config, $db);
    }

    public static function negotiator(?RequestInterface $request = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('negotiator', $request);
        }
        $request ??= AppServices::request();
        return new Negotiate($request);
    }

    public static function pager(?PagerConfig $config = null, ?RendererInterface $view = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('pager', $config, $view);
        }
        $config ??= config('Pager');
        $view ??= AppServices::renderer();
        return new Pager($config, $view);
    }

    public static function renderer(?string $viewPath = null, ?ViewConfig $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('renderer', $viewPath, $config);
        }
        $viewPath = $viewPath ?: config('Paths')->viewDirectory;
        $config ??= config('View');
        return new View($config, $viewPath, AppServices::locator(), CI_DEBUG, AppServices::logger());
    }

    public static function logger(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('logger');
        }
        return new Logger(config('Logger'));
    }

    public static function parser(?string $viewPath = null, ?ViewConfig $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('parser', $viewPath, $config);
        }
        $viewPath = $viewPath ?: config('Paths')->viewDirectory;
        $config ??= config('View');
        return new Parser($config, $viewPath, AppServices::locator(), CI_DEBUG, AppServices::logger());
    }

    public static function createRequest(App $config, bool $isCli = false): void
    {
        if ($isCli) {
            $request = AppServices::clirequest($config);
        } else {
            $request = AppServices::incomingrequest($config);
            $request->setProtocolVersion($_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.1');
        }
        static::$instances['request'] = $request;
    }

    public static function clirequest(?App $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('clirequest', $config);
        }
        $config ??= config('App');
        return new CLIRequest($config);
    }

    public static function redirectresponse(?App $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('redirectresponse', $config);
        }
        $config ??= config('App');
        $response = new RedirectResponse($config);
        $response->setProtocolVersion(AppServices::request()->getProtocolVersion());
        return $response;
    }

    public static function router(?RouteCollectionInterface $routes = null, ?Request $request = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('router', $routes, $request);
        }
        $routes ??= AppServices::routes();
        $request ??= AppServices::request();
        return new Router($routes, $request);
    }

    public static function routes(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('routes');
        }
        return new RouteCollection(AppServices::locator(), config('Modules'));
    }

    public static function security(?App $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('security', $config);
        }
        $config ??= config('App');
        return new Security($config);
    }

    public static function session(?App $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('session', $config);
        }
        $config ??= config('App');
        assert($config instanceof App);
        $logger = AppServices::logger();
        $sessionConfig = config('Session');
        $driverName = $sessionConfig->driver ?? $config->sessionDriver;
        if ($driverName === DatabaseHandler::class) {
            $DBGroup = $sessionConfig->DBGroup ?? $config->sessionDBGroup ?? config(Database::class)->defaultGroup;
            $db = Database::connect($DBGroup);
            $driver = $db->getPlatform();
            if ($driver === 'MySQLi') {
                $driverName = MySQLiHandler::class;
            } elseif ($driver === 'Postgre') {
                $driverName = PostgreHandler::class;
            }
        }
        $driver = new $driverName($config, AppServices::request()->getIPAddress());
        $driver->setLogger($logger);
        $session = new Session($driver, $config);
        $session->setLogger($logger);
        if (session_status() === PHP_SESSION_NONE) {
            $session->start();
        }
        return $session;
    }

    public static function throttler(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('throttler');
        }
        return new Throttler(AppServices::cache());
    }

    public static function cache(?Cache $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('cache', $config);
        }
        $config ??= new Cache();
        return CacheFactory::getHandler($config);
    }

    public static function timer(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('timer');
        }
        return new Timer();
    }

    public static function toolbar(?ToolbarConfig $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('toolbar', $config);
        }
        $config ??= config('Toolbar');
        return new Toolbar($config);
    }

    public static function validation(?ValidationConfig $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('validation', $config);
        }
        $config ??= config('Validation');
        return new Validation($config, AppServices::renderer());
    }

    public static function viewcell(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('viewcell');
        }
        return new Cell(AppServices::cache());
    }

    public static function typography(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('typography');
        }
        return new Typography();
    }
}