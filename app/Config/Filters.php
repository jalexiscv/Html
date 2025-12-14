<?php


namespace Config;

use App\Filters\SingleTabFilter;
use Higgs\Config\BaseConfig;
use Higgs\Filters\CSRF;
use Higgs\Filters\DebugToolbar;
use Higgs\Filters\Honeypot;
use Higgs\Filters\InvalidChars;
use Higgs\Filters\SecureHeaders;


class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     */
    public array $aliases = [
        'csrf' => CSRF::class,
        'toolbar' => DebugToolbar::class,
        'honeypot' => Honeypot::class,
        'invalidchars' => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'singletab'     => SingleTabFilter::class,
        // No se define un alias para 'session' porque la clase no existe.
    ];
    /**
     * List of filter aliases that are always
     * applied before and after every request.
     */
    public array $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
            // Se comenta la siguiente línea porque el filtro 'session' no existe y causa un error fatal.
            // 'session' => ['except' => ['ui/*', 'login*', '/', 'hook']]
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];
    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don’t expect could bypass the filter.
     */
    public array $methods = [];
    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     */
    public array $filters = [];

    public function __construct()
    {
        parent::__construct();

    }


}
?>