<?php

namespace Twilio\Rest\Events\V1;

use Twilio\ListResource;
use Twilio\Version;

class SchemaList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(string $id): SchemaContext
    {
        return new SchemaContext($this->version, $id);
    }

    public function __toString(): string
    {
        return '[Twilio.Events.V1.SchemaList]';
    }
}