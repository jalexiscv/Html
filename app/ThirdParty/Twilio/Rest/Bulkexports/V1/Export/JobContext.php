<?php

namespace Twilio\Rest\Bulkexports\V1\Export;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class JobContext extends InstanceContext
{
    public function __construct(Version $version, $jobSid)
    {
        parent::__construct($version);
        $this->solution = ['jobSid' => $jobSid,];
        $this->uri = '/Exports/Jobs/' . rawurlencode($jobSid) . '';
    }

    public function fetch(): JobInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new JobInstance($this->version, $payload, $this->solution['jobSid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Bulkexports.V1.JobContext ' . implode(' ', $context) . ']';
    }
}