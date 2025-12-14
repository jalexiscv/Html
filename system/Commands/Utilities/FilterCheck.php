<?php

namespace Higgs\Commands\Utilities;

use Higgs\CLI\BaseCommand;
use Higgs\CLI\CLI;
use Higgs\Commands\Utilities\Routes\FilterCollector;
use Config\Services;

class FilterCheck extends BaseCommand
{
    protected $group = 'Higgs';
    protected $name = 'filter:check';
    protected $description = 'Check filters for a route.';
    protected $usage = 'filter:check <HTTP method> <route>';
    protected $arguments = ['method' => 'The HTTP method. get, post, put, etc.', 'route' => 'The route (URI path) to check filtes.',];
    protected $options = [];

    public function run(array $params)
    {
        if (!isset($params[0], $params[1])) {
            CLI::error('You must specify a HTTP verb and a route.');
            CLI::write('  Usage: ' . $this->usage);
            CLI::write('Example: filter:check get /');
            CLI::write('         filter:check put products/1');
            return EXIT_ERROR;
        }
        $method = strtolower($params[0]);
        $route = $params[1];
        Services::routes()->loadRoutes();
        $filterCollector = new FilterCollector();
        $filters = $filterCollector->get($method, $route);
        if ($filters['before'] === ['<unknown>']) {
            CLI::error("Can't find a route: " . CLI::color('"' . strtoupper($method) . ' ' . $route . '"', 'black', 'light_gray'),);
            return EXIT_ERROR;
        }
        $tbody[] = [strtoupper($method), $route, implode(' ', $filters['before']), implode(' ', $filters['after']),];
        $thead = ['Method', 'Route', 'Before Filters', 'After Filters',];
        CLI::table($tbody, $thead);
        return EXIT_SUCCESS;
    }
}