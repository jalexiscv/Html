<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Taskrouter\V1\Workspace\Task\ReservationContext;
use Twilio\Rest\Taskrouter\V1\Workspace\Task\ReservationList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class TaskContext extends InstanceContext
{
    protected $_reservations;

    public function __construct(Version $version, $workspaceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['workspaceSid' => $workspaceSid, 'sid' => $sid,];
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Tasks/' . rawurlencode($sid) . '';
    }

    public function fetch(): TaskInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new TaskInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['sid']);
    }

    public function update(array $options = []): TaskInstance
    {
        $options = new Values($options);
        $data = Values::of(['Attributes' => $options['attributes'], 'AssignmentStatus' => $options['assignmentStatus'], 'Reason' => $options['reason'], 'Priority' => $options['priority'], 'TaskChannel' => $options['taskChannel'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new TaskInstance($this->version, $payload, $this->solution['workspaceSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getReservations(): ReservationList
    {
        if (!$this->_reservations) {
            $this->_reservations = new ReservationList($this->version, $this->solution['workspaceSid'], $this->solution['sid']);
        }
        return $this->_reservations;
    }

    public function __get(string $name): ListResource
    {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown subresource ' . $name);
    }

    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        throw new TwilioException('Resource does not have a context');
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Taskrouter.V1.TaskContext ' . implode(' ', $context) . ']';
    }
}