<?php

namespace Higgs\Commands\Utilities\Routes;

use Higgs\Config\Services;
use Higgs\Router\RouteCollection;

final class SampleURIGenerator
{
    private RouteCollection $routes;
    private array $samples = ['any' => '123/abc', 'segment' => 'abc_123', 'alphanum' => 'abc123', 'num' => '123', 'alpha' => 'abc', 'hash' => 'abc_123',];

    public function __construct(?RouteCollection $routes = null)
    {
        $this->routes = $routes ?? Services::routes();
    }

    public function get(string $routeKey): string
    {
        $sampleUri = $routeKey;
        foreach ($this->routes->getPlaceholders() as $placeholder => $regex) {
            $sample = $this->samples[$placeholder] ?? '::unknown::';
            $sampleUri = str_replace('(' . $regex . ')', $sample, $sampleUri);
        }
        return str_replace('[/...]', '/1/2/3/4/5', $sampleUri);
    }
}