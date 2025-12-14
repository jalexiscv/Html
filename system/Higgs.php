<?php

namespace Higgs;

use Closure;
use Higgs\Debug\Timer;
use Higgs\Events\Events;
use Higgs\Exceptions\FrameworkException;
use Higgs\Exceptions\PageNotFoundException;
use Higgs\HTTP\CLIRequest;
use Higgs\HTTP\DownloadResponse;
use Higgs\HTTP\IncomingRequest;
use Higgs\HTTP\RedirectResponse;
use Higgs\HTTP\Request;
use Higgs\HTTP\ResponseInterface;
use Higgs\HTTP\URI;
use Higgs\Router\Exceptions\RedirectException;
use Higgs\Router\RouteCollectionInterface;
use Higgs\Router\Router;
use Config\App;
use Config\Cache;
use Config\Kint as KintConfig;
use Config\Services;
use Exception;
use Kint;
use Kint\Renderer\CliRenderer;
use Kint\Renderer\RichRenderer;
use Locale;
use LogicException;

class Higgs
{
    public const CI_VERSION = '4.3.0';
    protected static $cacheTTL = 0;
    protected $startTime;
    protected $totalTime;
    protected $config;
    protected $benchmark;
    protected $request;
    protected $response;
    protected $router;
    protected $controller;
    protected $method;
    protected $output;
    protected $path;
    protected $useSafeOutput = false;
    protected ?string $context = null;
    protected bool $enableFilters = true;
    protected bool $returnResponse = false;

    public function __construct(App $config)
    {
        $this->startTime = microtime(true);
        $this->config = $config;
    }

    public static function cache(int $time)
    {
        static::$cacheTTL = $time;
    }

    public function initialize()
    {
        $this->detectEnvironment();
        $this->bootstrapEnvironment();
        Services::exceptions()->initialize();
        if (!is_file(COMPOSER_PATH)) {
            $this->resolvePlatformExtensions();
        }
        Locale::setDefault($this->config->defaultLocale ?? 'en');
        date_default_timezone_set($this->config->appTimezone ?? 'UTC');
        $this->initializeKint();
    }

    protected function detectEnvironment()
    {
        if (!defined('ENVIRONMENT')) {
            define('ENVIRONMENT', env('CI_ENVIRONMENT', 'development'));
        }
    }

    protected function bootstrapEnvironment()
    {
        if (is_file(APPPATH . 'Config/Boot/' . ENVIRONMENT . '.php')) {
            require_once APPPATH . 'Config/Boot/' . ENVIRONMENT . '.php';
        } else {
            header('HTTP/1.1 503 Service Unavailable.', true, 503);
            echo 'The application environment is not set correctly.';
            exit(EXIT_ERROR);
        }
    }

    protected function resolvePlatformExtensions()
    {
        $requiredExtensions = ['intl', 'json', 'mbstring',];
        //$requiredExtensions = ['json', 'mbstring',];
        $missingExtensions = [];
        foreach ($requiredExtensions as $extension) {
            if (!extension_loaded($extension)) {
                $missingExtensions[] = $extension;
            }
        }
        if ($missingExtensions !== []) {
            throw FrameworkException::forMissingExtension(implode(', ', $missingExtensions));
        }
    }

    protected function initializeKint()
    {
        if (CI_DEBUG) {
            $this->autoloadKint();
            $this->configureKint();
        } elseif (class_exists(Kint::class)) {
            Kint::$enabled_mode = false;
        }
        helper('kint');
    }

    private function autoloadKint(): void
    {
        if (!defined('KINT_DIR')) {
            spl_autoload_register(function ($class) {
                $class = explode('\\', $class);
                if (array_shift($class) !== 'Kint') {
                    return;
                }
                $file = SYSTEMPATH . 'ThirdParty/Kint/' . implode('/', $class) . '.php';
                if (is_file($file)) {
                    require_once $file;
                }
            });
            require_once SYSTEMPATH . 'ThirdParty/Kint/init.php';
        }
    }

    private function configureKint(): void
    {
        $config = config(KintConfig::class);
        Kint::$depth_limit = $config->maxDepth;
        Kint::$display_called_from = $config->displayCalledFrom;
        Kint::$expanded = $config->expanded;
        if (!empty($config->plugins) && is_array($config->plugins)) {
            Kint::$plugins = $config->plugins;
        }
        $csp = Services::csp();
        if ($csp->enabled()) {
            RichRenderer::$js_nonce = $csp->getScriptNonce();
            RichRenderer::$css_nonce = $csp->getStyleNonce();
        }
        RichRenderer::$theme = $config->richTheme;
        RichRenderer::$folder = $config->richFolder;
        RichRenderer::$sort = $config->richSort;
        if (!empty($config->richObjectPlugins) && is_array($config->richObjectPlugins)) {
            RichRenderer::$value_plugins = $config->richObjectPlugins;
        }
        if (!empty($config->richTabPlugins) && is_array($config->richTabPlugins)) {
            RichRenderer::$tab_plugins = $config->richTabPlugins;
        }
        CliRenderer::$cli_colors = $config->cliColors;
        CliRenderer::$force_utf8 = $config->cliForceUTF8;
        CliRenderer::$detect_width = $config->cliDetectWidth;
        CliRenderer::$min_terminal_width = $config->cliMinWidth;
    }

    public function run(?RouteCollectionInterface $routes = null, bool $returnResponse = false)
    {


        $this->returnResponse = $returnResponse;
        if ($this->context === null) {
            throw new LogicException('Context must be set before run() is called. If you are upgrading from 4.1.x, ' . 'you need to merge `public/index.php` and `spark` file from `vendor/Anssible4/framework`.');
        }
        static::$cacheTTL = 0;
        $this->startBenchmark();
        $this->getRequestObject();
        $this->getResponseObject();
        $this->forceSecureAccess();
        $this->spoofRequestMethod();
        if ($this->request instanceof IncomingRequest && strtolower($this->request->getMethod()) === 'cli') {
            $this->response->setStatusCode(405)->setBody('Method Not Allowed');
            if ($this->returnResponse) {
                return $this->response;
            }
            $this->sendResponse();
            return;
        }
        Events::trigger('pre_system');
        $cacheConfig = new Cache();
        $response = $this->displayCache($cacheConfig);
        if ($response instanceof ResponseInterface) {
            if ($returnResponse) {
                return $response;
            }
            $this->response->send();
            $this->callExit(EXIT_SUCCESS);
            return;
        }
        try {
            return $this->handleRequest($routes, $cacheConfig, $returnResponse);
        } catch (RedirectException $e) {
            $logger = Services::logger();
            $logger->info('REDIRECTED ROUTE at ' . $e->getMessage());
            $this->response->redirect(base_url($e->getMessage()), 'auto', $e->getCode());
            if ($this->returnResponse) {
                return $this->response;
            }
            $this->sendResponse();
            $this->callExit(EXIT_SUCCESS);
            return;
        } catch (PageNotFoundException $e) {
            $return = $this->display404errors($e);
            if ($return instanceof ResponseInterface) {
                return $return;
            }
        }
    }

    protected function startBenchmark()
    {
        if ($this->startTime === null) {
            $this->startTime = microtime(true);
        }
        $this->benchmark = Services::timer();
        $this->benchmark->start('total_execution', $this->startTime);
        $this->benchmark->start('bootstrap');
    }

    protected function getRequestObject()
    {
        if ($this->request instanceof Request) {
            return;
        }
        if ($this->isPhpCli()) {
            Services::createRequest($this->config, true);
        } else {
            Services::createRequest($this->config);
        }
        $this->request = Services::request();
    }

    private function isPhpCli(): bool
    {
        return $this->context === 'php-cli';
    }

    protected function getResponseObject()
    {
        $this->response = Services::response($this->config);
        if ($this->isWeb()) {
            $this->response->setProtocolVersion($this->request->getProtocolVersion());
        }
        $this->response->setStatusCode(200);
    }

    private function isWeb(): bool
    {
        return $this->context === 'web';
    }

    protected function forceSecureAccess($duration = 31_536_000)
    {
        if ($this->config->forceGlobalSecureRequests !== true) {
            return;
        }
        force_https($duration, $this->request, $this->response);
    }

    public function spoofRequestMethod()
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return;
        }
        $method = $this->request->getPost('_method');
        if (empty($method)) {
            return;
        }
        if (in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE'], true)) {
            $this->request = $this->request->setMethod($method);
        }
    }

    protected function sendResponse()
    {
        $this->response->send();
    }

    public function displayCache(Cache $config)
    {
        if ($cachedResponse = cache()->get($this->generateCacheName($config))) {
            $cachedResponse = unserialize($cachedResponse);
            if (!is_array($cachedResponse) || !isset($cachedResponse['output']) || !isset($cachedResponse['headers'])) {
                throw new Exception('Error unserializing page cache');
            }
            $headers = $cachedResponse['headers'];
            $output = $cachedResponse['output'];
            foreach (array_keys($this->response->headers()) as $key) {
                $this->response->removeHeader($key);
            }
            foreach ($headers as $name => $value) {
                $this->response->setHeader($name, $value);
            }
            $this->totalTime = $this->benchmark->getElapsedTime('total_execution');
            $output = $this->displayPerformanceMetrics($output);
            $this->response->setBody($output);
            return $this->response;
        }
        return false;
    }

    protected function generateCacheName(Cache $config): string
    {
        if ($this->request instanceof CLIRequest) {
            return md5($this->request->getPath());
        }
        $uri = clone $this->request->getUri();
        $query = $config->cacheQueryString ? $uri->getQuery(is_array($config->cacheQueryString) ? ['only' => $config->cacheQueryString] : []) : '';
        return md5($uri->setFragment('')->setQuery($query));
    }

    public function displayPerformanceMetrics(string $output): string
    {
        return str_replace('{elapsed_time}', (string)$this->totalTime, $output);
    }

    protected function callExit($code)
    {
        exit($code);
    }

    protected function handleRequest(?RouteCollectionInterface $routes, Cache $cacheConfig, bool $returnResponse = false)
    {
        $this->returnResponse = $returnResponse;
        $routeFilter = $this->tryToRouteIt($routes);
        $uri = $this->determinePath();
        if ($this->enableFilters) {
            $filters = Services::filters();
            if ($routeFilter !== null) {
                $multipleFiltersEnabled = config('Feature')->multipleFilters ?? false;
                if ($multipleFiltersEnabled) {
                    $filters->enableFilters($routeFilter, 'before');
                    $filters->enableFilters($routeFilter, 'after');
                } else {
                    $filters->enableFilter($routeFilter, 'before');
                    $filters->enableFilter($routeFilter, 'after');
                }
            }
            $this->benchmark->start('before_filters');
            $possibleResponse = $filters->run($uri, 'before');
            $this->benchmark->stop('before_filters');
            if ($possibleResponse instanceof ResponseInterface) {
                return $this->returnResponse ? $possibleResponse : $possibleResponse->send();
            }
            if ($possibleResponse instanceof Request) {
                $this->request = $possibleResponse;
            }
        }
        $returned = $this->startController();
        if (!is_callable($this->controller)) {
            $controller = $this->createController();
            if (!method_exists($controller, '_remap') && !is_callable([$controller, $this->method], false)) {
                throw PageNotFoundException::forMethodNotFound($this->method);
            }
            Events::trigger('post_controller_constructor');
            $returned = $this->runController($controller);
        } else {
            $this->benchmark->stop('controller_constructor');
            $this->benchmark->stop('controller');
        }
        $this->gatherOutput($cacheConfig, $returned);
        if ($this->enableFilters) {
            $filters = Services::filters();
            $filters->setResponse($this->response);
            $this->totalTime = $this->benchmark->getElapsedTime('total_execution');
            $this->benchmark->start('after_filters');
            $response = $filters->run($uri, 'after');
            $this->benchmark->stop('after_filters');
            if ($response instanceof ResponseInterface) {
                $this->response = $response;
            }
        }
        if (!$this->response instanceof DownloadResponse && !$this->response instanceof RedirectResponse) {
            if (static::$cacheTTL > 0) {
                $this->cachePage($cacheConfig);
            }
            $body = $this->response->getBody();
            if ($body !== null) {
                $output = $this->displayPerformanceMetrics($body);
                $this->response->setBody($output);
            }
            $this->storePreviousURL(current_url(true));
        }
        unset($uri);
        if (!$this->returnResponse) {
            $this->sendResponse();
        }
        Events::trigger('post_system');
        return $this->response;
    }

    protected function tryToRouteIt(?RouteCollectionInterface $routes = null)
    {
        if ($routes === null) {
            $routes = Services::routes()->loadRoutes();
        }
        $this->router = Services::router($routes, $this->request);
        $path = $this->determinePath();
        $this->benchmark->stop('bootstrap');
        $this->benchmark->start('routing');
        ob_start();
        $this->controller = $this->router->handle($path);
        $this->method = $this->router->methodName();
        if ($this->router->hasLocale()) {
            $this->request->setLocale($this->router->getLocale());
        }
        $this->benchmark->stop('routing');
        $multipleFiltersEnabled = config('Feature')->multipleFilters ?? false;
        if (!$multipleFiltersEnabled) {
            return $this->router->getFilter();
        }
        return $this->router->getFilters();
    }

    protected function determinePath()
    {
        if (!empty($this->path)) {
            return $this->path;
        }
        return method_exists($this->request, 'getPath') ? $this->request->getPath() : $this->request->getUri()->getPath();
    }

    protected function startController()
    {
        $this->benchmark->start('controller');
        $this->benchmark->start('controller_constructor');
        if (is_object($this->controller) && (get_class($this->controller) === 'Closure')) {
            $controller = $this->controller;
            return $controller(...$this->router->params());
        }
        if (empty($this->controller)) {
            throw PageNotFoundException::forEmptyController();
        }
        if (!class_exists($this->controller, true) || $this->method[0] === '_') {
            throw PageNotFoundException::forControllerNotFound($this->controller, $this->method);
        }
    }

    protected function createController()
    {
        assert(is_string($this->controller));
        $class = new $this->controller();
        $class->initController($this->request, $this->response, Services::logger());
        $this->benchmark->stop('controller_constructor');
        return $class;
    }

    protected function runController($class)
    {
        $params = $this->router->params();
        $output = method_exists($class, '_remap') ? $class->_remap($this->method, ...$params) : $class->{$this->method}(...$params);
        $this->benchmark->stop('controller');
        return $output;
    }

    protected function gatherOutput(?Cache $cacheConfig = null, $returned = null)
    {
        $this->output = ob_get_contents();
        if (ob_get_length()) {
            ob_end_clean();
        }
        if ($returned instanceof DownloadResponse) {
            if (ENVIRONMENT !== 'testing') {
                while (ob_get_level() > 0) {
                    ob_end_clean();
                }
            }
            $this->response = $returned;
            return;
        }
        if ($returned instanceof ResponseInterface) {
            $this->response = $returned;
            $returned = $returned->getBody();
        }
        if (is_string($returned)) {
            $this->output .= $returned;
        }
        $this->response->setBody($this->output);
    }

    public function cachePage(Cache $config)
    {
        $headers = [];
        foreach ($this->response->headers() as $header) {
            $headers[$header->getName()] = $header->getValueLine();
        }
        return cache()->save($this->generateCacheName($config), serialize(['headers' => $headers, 'output' => $this->output]), static::$cacheTTL);
    }

    public function storePreviousURL($uri)
    {
        if (!$this->isWeb()) {
            return;
        }
        if (method_exists($this->request, 'isAJAX') && $this->request->isAJAX()) {
            return;
        }
        if ($this->response instanceof DownloadResponse || $this->response instanceof RedirectResponse) {
            return;
        }
        if (strpos($this->response->getHeaderLine('Content-Type'), 'text/html') === false) {
            return;
        }
        if (is_string($uri)) {
            $uri = new URI($uri);
        }
        if (isset($_SESSION)) {
            $_SESSION['_ci_previous_url'] = URI::createURIString($uri->getScheme(), $uri->getAuthority(), $uri->getPath(), $uri->getQuery(), $uri->getFragment());
        }
    }

    protected function display404errors(PageNotFoundException $e)
    {
        if ($override = $this->router->get404Override()) {
            $returned = null;
            if ($override instanceof Closure) {
                echo $override($e->getMessage());
            } elseif (is_array($override)) {
                $this->benchmark->start('controller');
                $this->benchmark->start('controller_constructor');
                $this->controller = $override[0];
                $this->method = $override[1];
                $controller = $this->createController();
                $returned = $this->runController($controller);
            }
            unset($override);
            $cacheConfig = new Cache();
            $this->gatherOutput($cacheConfig, $returned);
            if ($this->returnResponse) {
                return $this->response;
            }
            $this->sendResponse();
            return;
        }
        $this->response->setStatusCode($e->getCode());
        if (ENVIRONMENT !== 'testing') {
            if (ob_get_level() > 0) {
                ob_end_flush();
            }
        } elseif (ob_get_level() > 2) {
            ob_end_flush();
        }
        throw PageNotFoundException::forPageNotFound((ENVIRONMENT !== 'production' || !$this->isWeb()) ? $e->getMessage() : null);
    }

    public function useSafeOutput(bool $safe = true)
    {
        $this->useSafeOutput = $safe;
        return $this;
    }

    public function disableFilters(): void
    {
        $this->enableFilters = false;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    public function getPerformanceStats(): array
    {
        return ['startTime' => $this->startTime, 'totalTime' => $this->totalTime,];
    }

    public function setPath(string $path)
    {
        $this->path = $path;
        return $this;
    }

    public function setContext(string $context)
    {
        $this->context = $context;
        return $this;
    }
}