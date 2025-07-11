<?php

namespace Thruway\Transport;

use Thruway\Module\RouterModule;

abstract class AbstractRouterTransportProvider extends RouterModule implements RouterTransportProviderInterface
{
    /**
     * @var boolean
     */
    protected $trusted;

    /**
     * @param boolean $trusted
     */
    public function setTrusted($trusted)
    {
        $this->trusted = $trusted;
    }
}
