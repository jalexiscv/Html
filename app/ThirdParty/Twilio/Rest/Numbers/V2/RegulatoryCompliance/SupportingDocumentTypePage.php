<?php

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class SupportingDocumentTypePage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): SupportingDocumentTypeInstance
    {
        return new SupportingDocumentTypeInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Numbers.V2.SupportingDocumentTypePage]';
    }
}