<?php

namespace Twilio\Rest\FlexApi\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class FlexFlowOptions
{
    public static function read(string $friendlyName = Values::NONE): ReadFlexFlowOptions
    {
        return new ReadFlexFlowOptions($friendlyName);
    }

    public static function create(string $contactIdentity = Values::NONE, bool $enabled = Values::NONE, string $integrationType = Values::NONE, string $integrationFlowSid = Values::NONE, string $integrationUrl = Values::NONE, string $integrationWorkspaceSid = Values::NONE, string $integrationWorkflowSid = Values::NONE, string $integrationChannel = Values::NONE, int $integrationTimeout = Values::NONE, int $integrationPriority = Values::NONE, bool $integrationCreationOnMessage = Values::NONE, bool $longLived = Values::NONE, bool $janitorEnabled = Values::NONE, int $integrationRetryCount = Values::NONE): CreateFlexFlowOptions
    {
        return new CreateFlexFlowOptions($contactIdentity, $enabled, $integrationType, $integrationFlowSid, $integrationUrl, $integrationWorkspaceSid, $integrationWorkflowSid, $integrationChannel, $integrationTimeout, $integrationPriority, $integrationCreationOnMessage, $longLived, $janitorEnabled, $integrationRetryCount);
    }

    public static function update(string $friendlyName = Values::NONE, string $chatServiceSid = Values::NONE, string $channelType = Values::NONE, string $contactIdentity = Values::NONE, bool $enabled = Values::NONE, string $integrationType = Values::NONE, string $integrationFlowSid = Values::NONE, string $integrationUrl = Values::NONE, string $integrationWorkspaceSid = Values::NONE, string $integrationWorkflowSid = Values::NONE, string $integrationChannel = Values::NONE, int $integrationTimeout = Values::NONE, int $integrationPriority = Values::NONE, bool $integrationCreationOnMessage = Values::NONE, bool $longLived = Values::NONE, bool $janitorEnabled = Values::NONE, int $integrationRetryCount = Values::NONE): UpdateFlexFlowOptions
    {
        return new UpdateFlexFlowOptions($friendlyName, $chatServiceSid, $channelType, $contactIdentity, $enabled, $integrationType, $integrationFlowSid, $integrationUrl, $integrationWorkspaceSid, $integrationWorkflowSid, $integrationChannel, $integrationTimeout, $integrationPriority, $integrationCreationOnMessage, $longLived, $janitorEnabled, $integrationRetryCount);
    }
}

class ReadFlexFlowOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.FlexApi.V1.ReadFlexFlowOptions ' . $options . ']';
    }
}

class CreateFlexFlowOptions extends Options
{
    public function __construct(string $contactIdentity = Values::NONE, bool $enabled = Values::NONE, string $integrationType = Values::NONE, string $integrationFlowSid = Values::NONE, string $integrationUrl = Values::NONE, string $integrationWorkspaceSid = Values::NONE, string $integrationWorkflowSid = Values::NONE, string $integrationChannel = Values::NONE, int $integrationTimeout = Values::NONE, int $integrationPriority = Values::NONE, bool $integrationCreationOnMessage = Values::NONE, bool $longLived = Values::NONE, bool $janitorEnabled = Values::NONE, int $integrationRetryCount = Values::NONE)
    {
        $this->options['contactIdentity'] = $contactIdentity;
        $this->options['enabled'] = $enabled;
        $this->options['integrationType'] = $integrationType;
        $this->options['integrationFlowSid'] = $integrationFlowSid;
        $this->options['integrationUrl'] = $integrationUrl;
        $this->options['integrationWorkspaceSid'] = $integrationWorkspaceSid;
        $this->options['integrationWorkflowSid'] = $integrationWorkflowSid;
        $this->options['integrationChannel'] = $integrationChannel;
        $this->options['integrationTimeout'] = $integrationTimeout;
        $this->options['integrationPriority'] = $integrationPriority;
        $this->options['integrationCreationOnMessage'] = $integrationCreationOnMessage;
        $this->options['longLived'] = $longLived;
        $this->options['janitorEnabled'] = $janitorEnabled;
        $this->options['integrationRetryCount'] = $integrationRetryCount;
    }

    public function setContactIdentity(string $contactIdentity): self
    {
        $this->options['contactIdentity'] = $contactIdentity;
        return $this;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->options['enabled'] = $enabled;
        return $this;
    }

    public function setIntegrationType(string $integrationType): self
    {
        $this->options['integrationType'] = $integrationType;
        return $this;
    }

    public function setIntegrationFlowSid(string $integrationFlowSid): self
    {
        $this->options['integrationFlowSid'] = $integrationFlowSid;
        return $this;
    }

    public function setIntegrationUrl(string $integrationUrl): self
    {
        $this->options['integrationUrl'] = $integrationUrl;
        return $this;
    }

    public function setIntegrationWorkspaceSid(string $integrationWorkspaceSid): self
    {
        $this->options['integrationWorkspaceSid'] = $integrationWorkspaceSid;
        return $this;
    }

    public function setIntegrationWorkflowSid(string $integrationWorkflowSid): self
    {
        $this->options['integrationWorkflowSid'] = $integrationWorkflowSid;
        return $this;
    }

    public function setIntegrationChannel(string $integrationChannel): self
    {
        $this->options['integrationChannel'] = $integrationChannel;
        return $this;
    }

    public function setIntegrationTimeout(int $integrationTimeout): self
    {
        $this->options['integrationTimeout'] = $integrationTimeout;
        return $this;
    }

    public function setIntegrationPriority(int $integrationPriority): self
    {
        $this->options['integrationPriority'] = $integrationPriority;
        return $this;
    }

    public function setIntegrationCreationOnMessage(bool $integrationCreationOnMessage): self
    {
        $this->options['integrationCreationOnMessage'] = $integrationCreationOnMessage;
        return $this;
    }

    public function setLongLived(bool $longLived): self
    {
        $this->options['longLived'] = $longLived;
        return $this;
    }

    public function setJanitorEnabled(bool $janitorEnabled): self
    {
        $this->options['janitorEnabled'] = $janitorEnabled;
        return $this;
    }

    public function setIntegrationRetryCount(int $integrationRetryCount): self
    {
        $this->options['integrationRetryCount'] = $integrationRetryCount;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.FlexApi.V1.CreateFlexFlowOptions ' . $options . ']';
    }
}

class UpdateFlexFlowOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $chatServiceSid = Values::NONE, string $channelType = Values::NONE, string $contactIdentity = Values::NONE, bool $enabled = Values::NONE, string $integrationType = Values::NONE, string $integrationFlowSid = Values::NONE, string $integrationUrl = Values::NONE, string $integrationWorkspaceSid = Values::NONE, string $integrationWorkflowSid = Values::NONE, string $integrationChannel = Values::NONE, int $integrationTimeout = Values::NONE, int $integrationPriority = Values::NONE, bool $integrationCreationOnMessage = Values::NONE, bool $longLived = Values::NONE, bool $janitorEnabled = Values::NONE, int $integrationRetryCount = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['chatServiceSid'] = $chatServiceSid;
        $this->options['channelType'] = $channelType;
        $this->options['contactIdentity'] = $contactIdentity;
        $this->options['enabled'] = $enabled;
        $this->options['integrationType'] = $integrationType;
        $this->options['integrationFlowSid'] = $integrationFlowSid;
        $this->options['integrationUrl'] = $integrationUrl;
        $this->options['integrationWorkspaceSid'] = $integrationWorkspaceSid;
        $this->options['integrationWorkflowSid'] = $integrationWorkflowSid;
        $this->options['integrationChannel'] = $integrationChannel;
        $this->options['integrationTimeout'] = $integrationTimeout;
        $this->options['integrationPriority'] = $integrationPriority;
        $this->options['integrationCreationOnMessage'] = $integrationCreationOnMessage;
        $this->options['longLived'] = $longLived;
        $this->options['janitorEnabled'] = $janitorEnabled;
        $this->options['integrationRetryCount'] = $integrationRetryCount;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setChatServiceSid(string $chatServiceSid): self
    {
        $this->options['chatServiceSid'] = $chatServiceSid;
        return $this;
    }

    public function setChannelType(string $channelType): self
    {
        $this->options['channelType'] = $channelType;
        return $this;
    }

    public function setContactIdentity(string $contactIdentity): self
    {
        $this->options['contactIdentity'] = $contactIdentity;
        return $this;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->options['enabled'] = $enabled;
        return $this;
    }

    public function setIntegrationType(string $integrationType): self
    {
        $this->options['integrationType'] = $integrationType;
        return $this;
    }

    public function setIntegrationFlowSid(string $integrationFlowSid): self
    {
        $this->options['integrationFlowSid'] = $integrationFlowSid;
        return $this;
    }

    public function setIntegrationUrl(string $integrationUrl): self
    {
        $this->options['integrationUrl'] = $integrationUrl;
        return $this;
    }

    public function setIntegrationWorkspaceSid(string $integrationWorkspaceSid): self
    {
        $this->options['integrationWorkspaceSid'] = $integrationWorkspaceSid;
        return $this;
    }

    public function setIntegrationWorkflowSid(string $integrationWorkflowSid): self
    {
        $this->options['integrationWorkflowSid'] = $integrationWorkflowSid;
        return $this;
    }

    public function setIntegrationChannel(string $integrationChannel): self
    {
        $this->options['integrationChannel'] = $integrationChannel;
        return $this;
    }

    public function setIntegrationTimeout(int $integrationTimeout): self
    {
        $this->options['integrationTimeout'] = $integrationTimeout;
        return $this;
    }

    public function setIntegrationPriority(int $integrationPriority): self
    {
        $this->options['integrationPriority'] = $integrationPriority;
        return $this;
    }

    public function setIntegrationCreationOnMessage(bool $integrationCreationOnMessage): self
    {
        $this->options['integrationCreationOnMessage'] = $integrationCreationOnMessage;
        return $this;
    }

    public function setLongLived(bool $longLived): self
    {
        $this->options['longLived'] = $longLived;
        return $this;
    }

    public function setJanitorEnabled(bool $janitorEnabled): self
    {
        $this->options['janitorEnabled'] = $janitorEnabled;
        return $this;
    }

    public function setIntegrationRetryCount(int $integrationRetryCount): self
    {
        $this->options['integrationRetryCount'] = $integrationRetryCount;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.FlexApi.V1.UpdateFlexFlowOptions ' . $options . ']';
    }
}