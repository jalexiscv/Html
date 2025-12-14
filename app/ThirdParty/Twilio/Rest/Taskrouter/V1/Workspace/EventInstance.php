<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

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

class EventInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $workspaceSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'actorSid' => Values::array_get($payload, 'actor_sid'), 'actorType' => Values::array_get($payload, 'actor_type'), 'actorUrl' => Values::array_get($payload, 'actor_url'), 'description' => Values::array_get($payload, 'description'), 'eventData' => Values::array_get($payload, 'event_data'), 'eventDate' => Deserialize::dateTime(Values::array_get($payload, 'event_date')), 'eventDateMs' => Values::array_get($payload, 'event_date_ms'), 'eventType' => Values::array_get($payload, 'event_type'), 'resourceSid' => Values::array_get($payload, 'resource_sid'), 'resourceType' => Values::array_get($payload, 'resource_type'), 'resourceUrl' => Values::array_get($payload, 'resource_url'), 'sid' => Values::array_get($payload, 'sid'), 'source' => Values::array_get($payload, 'source'), 'sourceIpAddress' => Values::array_get($payload, 'source_ip_address'), 'url' => Values::array_get($payload, 'url'), 'workspaceSid' => Values::array_get($payload, 'workspace_sid'),];
        $this->solution = ['workspaceSid' => $workspaceSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): EventContext
    {
        if (!$this->context) {
            $this->context = new EventContext($this->version, $this->solution['workspaceSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): EventInstance
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
        return '[Twilio.Taskrouter.V1.EventInstance ' . implode(' ', $context) . ']';
    }
}