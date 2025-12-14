<?php

namespace App\Libraries\Sitemaps;

use App\Libraries\Sitemaps\SitemapInterface;

class Factory
{
    /**
     * Build a SEO object
     * @param string $class
     * @param array $args
     * @return SeoInterface
     */
    public static function __callStatic(string $class, array $args): SeoInterface
    {
        if (class_exists($class = __NAMESPACE__ . '\\' . ucfirst($class))) {
            return new $class(...$args);
        }
        throw new \Exceptions\SeoException("The class {$class} is not exists");
    }
}
