<?php

namespace Twilio\Rest\Bulkexports\V1\Export;

use Twilio\ListResource;
use Twilio\Version;

class JobList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    public function getContext(string $jobSid): JobContext
    {
        return new JobContext($this->version, $jobSid);
    }

    public function __toString(): string
    {
        return '[Twilio.Bulkexports.V1.JobList]';
    }
}