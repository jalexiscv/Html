<?php

namespace Config;

use Higgs\Config\BaseConfig;

/**
 * Enable/disable backward compatibility breaking features.
 */
class Feature extends BaseConfig
{
    /**
     * Enable multiple filters for a route or not.
     *
     * If you enable this:
     *   - Higgs\Higgs::handleRequest() uses:
     *     - Higgs\Filters\Filters::enableFilters(), instead of enableFilter()
     *   - Higgs\Higgs::tryToRouteIt() uses:
     *     - Higgs\Router\Router::getFilters(), instead of getFilter()
     *   - Higgs\Router\Router::handle() uses:
     *     - property $filtersInfo, instead of $filterInfo
     *     - Higgs\Router\RouteCollection::getFiltersForRoute(), instead of getFilterForRoute()
     */
    public bool $multipleFilters = false;

    /**
     * Use improved new auto routing instead of the default legacy version.
     */
    public bool $autoRoutesImproved = false;
}
