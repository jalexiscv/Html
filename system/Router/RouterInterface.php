<?php

namespace Higgs\Router;

use Closure;
use Higgs\HTTP\Request;

interface RouterInterface
{
    public function __construct(RouteCollectionInterface $routes, ?Request $request = null);

    public function handle(?string $uri = null);

    public function controllerName();

    public function methodName();

    public function params();

    public function setIndexPage($page);
}