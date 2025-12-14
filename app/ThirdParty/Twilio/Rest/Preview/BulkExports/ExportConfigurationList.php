<?php

namespace Twilio\Rest\Preview\BulkExports;

use Twilio\ListResource;
use Twilio\Version;

class ExportConfigurationList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(string $resourceType): ExportConfigurationContext
    {
        return new ExportConfigurationContext($this->version, $resourceType);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.BulkExports.ExportConfigurationList]';
    }
}