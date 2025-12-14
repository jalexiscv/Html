<?php

namespace Twilio\Rest\Studio\V2\Flow;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class FlowRevisionInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $sid, string $revision = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'definition' => Values::array_get($payload, 'definition'), 'status' => Values::array_get($payload, 'status'), 'revision' => Values::array_get($payload, 'revision'), 'commitMessage' => Values::array_get($payload, 'commit_message'), 'valid' => Values::array_get($payload, 'valid'), 'errors' => Values::array_get($payload, 'errors'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['sid' => $sid, 'revision' => $revision ?: $this->properties['revision'],];
    }

    public function fetch(): FlowRevisionInstance
    {
        return $this->proxy()->fetch();
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown property: ' . $name);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Studio.V2.FlowRevisionInstance ' . implode(' ', $context) . ']';
    }

    protected function proxy(): FlowRevisionContext
    {
        if (!$this->context) {
            $this->context = new FlowRevisionContext($this->version, $this->solution['sid'], $this->solution['revision']);
        }
        return $this->context;
    }
}