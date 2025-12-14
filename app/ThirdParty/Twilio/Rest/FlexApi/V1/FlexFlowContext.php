<?php

namespace Twilio\Rest\FlexApi\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class FlexFlowContext extends InstanceContext
{
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/FlexFlows/' . rawurlencode($sid) . '';
    }

    public function fetch(): FlexFlowInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new FlexFlowInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): FlexFlowInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'ChatServiceSid' => $options['chatServiceSid'], 'ChannelType' => $options['channelType'], 'ContactIdentity' => $options['contactIdentity'], 'Enabled' => Serialize::booleanToString($options['enabled']), 'IntegrationType' => $options['integrationType'], 'Integration.FlowSid' => $options['integrationFlowSid'], 'Integration.Url' => $options['integrationUrl'], 'Integration.WorkspaceSid' => $options['integrationWorkspaceSid'], 'Integration.WorkflowSid' => $options['integrationWorkflowSid'], 'Integration.Channel' => $options['integrationChannel'], 'Integration.Timeout' => $options['integrationTimeout'], 'Integration.Priority' => $options['integrationPriority'], 'Integration.CreationOnMessage' => Serialize::booleanToString($options['integrationCreationOnMessage']), 'LongLived' => Serialize::booleanToString($options['longLived']), 'JanitorEnabled' => Serialize::booleanToString($options['janitorEnabled']), 'Integration.RetryCount' => $options['integrationRetryCount'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new FlexFlowInstance($this->version, $payload, $this->solution['sid']);
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
        return '[Twilio.FlexApi.V1.FlexFlowContext ' . implode(' ', $context) . ']';
    }
}