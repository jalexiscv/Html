<?php

namespace Twilio\Rest\Verify\V2;

use Twilio\ListResource;
use Twilio\Version;

class FormList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(string $formType): FormContext
    {
        return new FormContext($this->version, $formType);
    }

    public function __toString(): string
    {
        return '[Twilio.Verify.V2.FormList]';
    }
}