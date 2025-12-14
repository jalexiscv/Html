<?php

namespace Twilio\Rest\Studio\V2;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Studio\V2\Flow\ExecutionList;
use Twilio\Rest\Studio\V2\Flow\FlowRevisionList;
use Twilio\Rest\Studio\V2\Flow\FlowTestUserList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class FlowInstance extends InstanceResource
{
    protected $_revisions;
    protected $_testUsers;
    protected $_executions;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'definition' => Values::array_get($payload, 'definition'), 'status' => Values::array_get($payload, 'status'), 'revision' => Values::array_get($payload, 'revision'), 'commitMessage' => Values::array_get($payload, 'commit_message'), 'valid' => Values::array_get($payload, 'valid'), 'errors' => Values::array_get($payload, 'errors'), 'warnings' => Values::array_get($payload, 'warnings'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'webhookUrl' => Values::array_get($payload, 'webhook_url'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    public function update(string $status, array $options = []): FlowInstance
    {
        return $this->proxy()->update($status, $options);
    }

    public function fetch(): FlowInstance
    {
        return $this->proxy()->fetch();
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
        return '[Twilio.Studio.V2.FlowInstance ' . implode(' ', $context) . ']';
    }

    protected function proxy(): FlowContext
    {
        if (!$this->context) {
            $this->context = new FlowContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    protected function getRevisions(): FlowRevisionList
    {
        return $this->proxy()->revisions;
    }

    protected function getTestUsers(): FlowTestUserList
    {
        return $this->proxy()->testUsers;
    }

    protected function getExecutions(): ExecutionList
    {
        return $this->proxy()->executions;
    }
}