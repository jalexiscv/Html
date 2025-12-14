<?php

namespace Twilio\Rest\Messaging\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;

class DeactivationsContext extends InstanceContext
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Deactivations';
    }

    public function fetch(array $options = []): DeactivationsInstance
    {
        $options = new Values($options);
        $params = Values::of(['Date' => Serialize::iso8601Date($options['date']),]);
        $payload = $this->version->fetch('GET', $this->uri, $params);
        return new DeactivationsInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Messaging.V1.DeactivationsContext ' . implode(' ', $context) . ']';
    }
}