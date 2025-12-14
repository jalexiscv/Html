<?php

namespace Twilio\Rest\Studio\V2;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Studio\V2\Flow\ExecutionContext;
use Twilio\Rest\Studio\V2\Flow\ExecutionList;
use Twilio\Rest\Studio\V2\Flow\FlowRevisionContext;
use Twilio\Rest\Studio\V2\Flow\FlowRevisionList;
use Twilio\Rest\Studio\V2\Flow\FlowTestUserContext;
use Twilio\Rest\Studio\V2\Flow\FlowTestUserList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class FlowContext extends InstanceContext
{
    protected $_revisions;
    protected $_testUsers;
    protected $_executions;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Flows/' . rawurlencode($sid) . '';
    }

    public function update(string $status, array $options = []): FlowInstance
    {
        $options = new Values($options);
        $data = Values::of(['Status' => $status, 'FriendlyName' => $options['friendlyName'], 'Definition' => Serialize::jsonObject($options['definition']), 'CommitMessage' => $options['commitMessage'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new FlowInstance($this->version, $payload, $this->solution['sid']);
    }

    public function fetch(): FlowInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new FlowInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
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
        return '[Twilio.Studio.V2.FlowContext ' . implode(' ', $context) . ']';
    }

    protected function getRevisions(): FlowRevisionList
    {
        if (!$this->_revisions) {
            $this->_revisions = new FlowRevisionList($this->version, $this->solution['sid']);
        }
        return $this->_revisions;
    }

    protected function getTestUsers(): FlowTestUserList
    {
        if (!$this->_testUsers) {
            $this->_testUsers = new FlowTestUserList($this->version, $this->solution['sid']);
        }
        return $this->_testUsers;
    }

    protected function getExecutions(): ExecutionList
    {
        if (!$this->_executions) {
            $this->_executions = new ExecutionList($this->version, $this->solution['sid']);
        }
        return $this->_executions;
    }
}