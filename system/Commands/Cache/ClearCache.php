<?php

namespace Higgs\Commands\Cache;

use Higgs\Cache\CacheFactory;
use Higgs\CLI\BaseCommand;
use Higgs\CLI\CLI;

class ClearCache extends BaseCommand
{
    protected $group = 'Cache';
    protected $name = 'cache:clear';
    protected $description = 'Clears the current system caches.';
    protected $usage = 'cache:clear [<driver>]';
    protected $arguments = ['driver' => 'The cache driver to use',];

    public function run(array $params)
    {
        $config = config('Cache');
        $handler = $params[0] ?? $config->handler;
        if (!array_key_exists($handler, $config->validHandlers)) {
            CLI::error($handler . ' is not a valid cache handler.');
            return;
        }
        $config->handler = $handler;
        $cache = CacheFactory::getHandler($config);
        if (!$cache->clean()) {
            CLI::error('Error while clearing the cache.');
            return;
        }
        CLI::write(CLI::color('Cache cleared.', 'green'));
    }
}