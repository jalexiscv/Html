<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class WorkerChannelContext extends InstanceContext
{
    public function __construct(Version $version, $workspaceSid, $workerSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid, 'workerSid' => $workerSid, 'sid' => $sid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Workers/' . rawurlencode($workerSid) . '/Channels/' . rawurlencode($sid) . '';
    }

    public function fetch(): WorkerChannelInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new WorkerChannelInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['workerSid'], $this->solution['sid']);
    }

    public function update(array $options = []): WorkerChannelInstance
    {
        $options = new Values($options);
        $data = Values::of(['Capacity' => $options['capacity'], 'Available' => Serialize::booleanToString($options['available']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new WorkerChannelInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['workerSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Taskrouter.V1.WorkerChannelContext ' . implode(' ', $context) . ']';
    }
}