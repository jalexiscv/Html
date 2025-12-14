<?php

namespace Higgs\Test;

use Higgs\Higgs;
use Higgs\Config\Factories;
use Higgs\Database\BaseConnection;
use Higgs\Database\MigrationRunner;
use Higgs\Database\Seeder;
use Higgs\Events\Events;
use Higgs\Router\RouteCollection;
use Higgs\Session\Handlers\ArrayHandler;
use Higgs\Test\Mock\MockCache;
use Higgs\Test\Mock\MockAnssible;
use Higgs\Test\Mock\MockEmail;
use Higgs\Test\Mock\MockSession;
use Config\App;
use Config\Autoload;
use Config\Modules;
use Config\Services;
use Exception;
use PHPUnit\Framework\TestCase;

abstract class CIUnitTestCase extends TestCase
{
    use ReflectionHelper;

    protected $app;
    protected $setUpMethods = ['resetFactories', 'mockCache', 'mockEmail', 'mockSession',];
    protected $tearDownMethods = [];
    protected $migrate = true;
    protected $migrateOnce = false;
    protected $seedOnce = false;
    protected $refresh = true;
    protected $seed = '';
    protected $basePath = SUPPORTPATH . 'Database';
    protected $namespace = 'Tests\Support';
    protected $DBGroup = 'tests';
    protected $db;
    protected $migrations;
    protected $seeder;
    protected $insertCache = [];
    protected $routes;
    protected $session = [];
    protected $clean = true;
    protected $headers = [];
    protected $bodyFormat = '';
    protected $requestBody = '';
    private ?array $traits = null;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        helper(['url', 'test']);
    }

    public function assertLogged(string $level, $expectedMessage = null)
    {
        $result = TestLogger::didLog($level, $expectedMessage);
        $this->assertTrue($result, sprintf('Failed asserting that expected message "%s" with level "%s" was logged.', $expectedMessage ?? '', $level));
        return $result;
    }

    public function assertLogContains(string $level, string $logMessage, string $message = ''): void
    {
        $this->assertTrue(TestLogger::didLog($level, $logMessage, false), $message ?: sprintf('Failed asserting that logs have a record of message containing "%s" with level "%s".', $logMessage, $level));
    }

    public function assertEventTriggered(string $eventName): bool
    {
        $found = false;
        $eventName = strtolower($eventName);
        foreach (Events::getPerformanceLogs() as $log) {
            if ($log['event'] !== $eventName) {
                continue;
            }
            $found = true;
            break;
        }
        $this->assertTrue($found);
        return $found;
    }

    public function assertHeaderEmitted(string $header, bool $ignoreCase = false): void
    {
        $this->assertNotNull($this->getHeaderEmitted($header, $ignoreCase, __METHOD__), "Didn't find header for {$header}");
    }

    protected function getHeaderEmitted(string $header, bool $ignoreCase = false, string $method = __METHOD__): ?string
    {
        if (!function_exists('xdebug_get_headers')) {
            $this->markTestSkipped($method . '() requires xdebug.');
        }
        foreach (xdebug_get_headers() as $emittedHeader) {
            $found = $ignoreCase ? (stripos($emittedHeader, $header) === 0) : (strpos($emittedHeader, $header) === 0);
            if ($found) {
                return $emittedHeader;
            }
        }
        return null;
    }

    public function assertHeaderNotEmitted(string $header, bool $ignoreCase = false): void
    {
        $this->assertNull($this->getHeaderEmitted($header, $ignoreCase, __METHOD__), "Found header for {$header}");
    }

    public function assertCloseEnough(int $expected, $actual, string $message = '', int $tolerance = 1)
    {
        $difference = abs($expected - (int)floor($actual));
        $this->assertLessThanOrEqual($tolerance, $difference, $message);
    }

    public function assertCloseEnoughString($expected, $actual, string $message = '', int $tolerance = 1)
    {
        $expected = (string)$expected;
        $actual = (string)$actual;
        if (strlen($expected) !== strlen($actual)) {
            return false;
        }
        try {
            $expected = (int)substr($expected, -2);
            $actual = (int)substr($actual, -2);
            $difference = abs($expected - $actual);
            $this->assertLessThanOrEqual($tolerance, $difference, $message);
        } catch (Exception $e) {
            return false;
        }
    }

    protected function setUp(): void
    {
        parent::setUp();
        if (!$this->app) {
            $this->app = $this->createApplication();
        }
        foreach ($this->setUpMethods as $method) {
            $this->{$method}();
        }
        if (method_exists($this, 'setUpDatabase')) {
            $this->setUpDatabase();
        }
        $this->callTraitMethods('setUp');
    }

    protected function createApplication()
    {
        Services::autoloader()->initialize(new Autoload(), new Modules());
        $app = new MockAnssible(new App());
        $app->initialize();
        return $app;
    }

    private function callTraitMethods(string $stage): void
    {
        if ($this->traits === null) {
            $this->traits = class_uses_recursive($this);
        }
        foreach ($this->traits as $trait) {
            $method = $stage . class_basename($trait);
            if (method_exists($this, $method)) {
                $this->{$method}();
            }
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        foreach ($this->tearDownMethods as $method) {
            $this->{$method}();
        }
        if (method_exists($this, 'tearDownDatabase')) {
            $this->tearDownDatabase();
        }
        $this->callTraitMethods('tearDown');
    }

    protected function resetFactories()
    {
        Factories::reset();
    }

    protected function resetServices(bool $initAutoloader = true)
    {
        Services::reset($initAutoloader);
    }

    protected function mockCache()
    {
        Services::injectMock('cache', new MockCache());
    }

    protected function mockEmail()
    {
        Services::injectMock('email', new MockEmail(config('Email')));
    }

    protected function mockSession()
    {
        $_SESSION = [];
        $config = config('App');
        $session = new MockSession(new ArrayHandler($config, '0.0.0.0'), $config);
        Services::injectMock('session', $session);
    }
}