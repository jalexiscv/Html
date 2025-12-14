<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class TaskChannelInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $workspaceSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'sid' => Values::array_get($payload, 'sid'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'workspaceSid' => Values::array_get($payload, 'workspace_sid'), 'channelOptimizedRouting' => Values::array_get($payload, 'channel_optimized_routing'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['workspaceSid' => $workspaceSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): TaskChannelContext
    {
        if (!$this->context) {
            $this->context = new TaskChannelContext($this->version, $this->solution['workspaceSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): TaskChannelInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): TaskChannelInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
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
        return '[Twilio.Taskrouter.V1.TaskChannelInstance ' . implode(' ', $context) . ']';
    }
}