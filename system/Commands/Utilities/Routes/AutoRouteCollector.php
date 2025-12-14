<?php

namespace Higgs\Commands\Utilities\Routes;
final class AutoRouteCollector
{
    private string $namespace;
    private string $defaultController;
    private string $defaultMethod;

    public function __construct(string $namespace, string $defaultController, string $defaultMethod)
    {
        $this->namespace = $namespace;
        $this->defaultController = $defaultController;
        $this->defaultMethod = $defaultMethod;
    }

    public function get(): array
    {
        $finder = new ControllerFinder($this->namespace);
        $reader = new ControllerMethodReader($this->namespace);
        $tbody = [];
        foreach ($finder->find() as $class) {
            $output = $reader->read($class, $this->defaultController, $this->defaultMethod);
            foreach ($output as $item) {
                $tbody[] = ['auto', $item['route'], '', $item['handler'],];
            }
        }
        return $tbody;
    }
}