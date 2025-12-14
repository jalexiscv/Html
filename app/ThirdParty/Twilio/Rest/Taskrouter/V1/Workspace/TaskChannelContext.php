<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class TaskChannelContext extends InstanceContext
{
    public function __construct(Version $version, $workspaceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid, 'sid' => $sid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/TaskChannels/' . rawurlencode($sid) . '';
    }

    public function fetch(): TaskChannelInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new TaskChannelInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['sid']);
    }

    public function update(array $options = []): TaskChannelInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'ChannelOptimizedRouting' => Serialize::booleanToString($options['channelOptimizedRouting']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new TaskChannelInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['sid']);
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
        return '[Twilio.Taskrouter.V1.TaskChannelContext ' . implode(' ', $context) . ']';
    }
}