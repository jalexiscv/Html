<?php

namespace Higgs\Router;
interface AutoRouterInterface
{
    public function getRoute(string $uri): array;
}