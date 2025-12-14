<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class EventContext extends InstanceContext
{
    public function __construct(Version $version, $workspaceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid, 'sid' => $sid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Events/' . rawurlencode($sid) . '';
    }

    public function fetch(): EventInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new EventInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Taskrouter.V1.EventContext ' . implode(' ', $context) . ']';
    }
}