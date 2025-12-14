<?php

namespace Higgs\Test;

use Higgs\Test\Filters\CITestStreamFilter;

trait StreamFilterTrait
{
    protected function setUpStreamFilterTrait(): void
    {
        CITestStreamFilter::registration();
        CITestStreamFilter::addOutputFilter();
        CITestStreamFilter::addErrorFilter();
    }

    protected function tearDownStreamFilterTrait(): void
    {
        CITestStreamFilter::removeOutputFilter();
        CITestStreamFilter::removeErrorFilter();
    }

    protected function getStreamFilterBuffer(): string
    {
        return CITestStreamFilter::$buffer;
    }

    protected function resetStreamFilterBuffer(): void
    {
        CITestStreamFilter::$buffer = '';
    }
}