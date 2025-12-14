<?php

namespace Twilio\Rest\Bulkexports\V1\Export;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class DayContext extends InstanceContext
{
    public function __construct(Version $version, $resourceType, $day)
    {
        parent::__construct($version);
        $this->solution = ['resourceType' => $resourceType, 'day' => $day,];
        $this->uri = '/Exports/' . rawurlencode($resourceType) . '/Days/' . rawurlencode($day) . '';
    }

    public function fetch(): DayInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new DayInstance($this->version, $payload, $this->solution['resourceType'], $this->solution['day']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Bulkexports.V1.DayContext ' . implode(' ', $context) . ']';
    }
}