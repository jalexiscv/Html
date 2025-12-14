<?php

namespace Twilio\Rest\Studio\V2\Flow;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class FlowRevisionContext extends InstanceContext
{
    public function __construct(Version $version, $sid, $revision)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid, 'revision' => $revision,];
        $this->uri = '/Flows/' . rawurlencode($sid) . '/Revisions/' . rawurlencode($revision) . '';
    }

    public function fetch(): FlowRevisionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new FlowRevisionInstance($this->version, $payload, $this->solution['sid'], $this->solution['revision']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Studio.V2.FlowRevisionContext ' . implode(' ', $context) . ']';
    }
}