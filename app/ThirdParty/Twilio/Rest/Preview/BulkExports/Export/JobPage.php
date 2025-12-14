<?php

namespace Twilio\Rest\Preview\BulkExports\Export;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class JobPage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): JobInstance
    {
        return new JobInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.BulkExports.JobPage]';
    }
}