<?php

namespace Twilio\Rest\Verify\V2;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Verify\V2\Service\AccessTokenList;
use Twilio\Rest\Verify\V2\Service\EntityContext;
use Twilio\Rest\Verify\V2\Service\EntityList;
use Twilio\Rest\Verify\V2\Service\MessagingConfigurationContext;
use Twilio\Rest\Verify\V2\Service\MessagingConfigurationList;
use Twilio\Rest\Verify\V2\Service\RateLimitContext;
use Twilio\Rest\Verify\V2\Service\RateLimitList;
use Twilio\Rest\Verify\V2\Service\VerificationCheckList;
use Twilio\Rest\Verify\V2\Service\VerificationContext;
use Twilio\Rest\Verify\V2\Service\VerificationList;
use Twilio\Rest\Verify\V2\Service\WebhookContext;
use Twilio\Rest\Verify\V2\Service\WebhookList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class ServiceContext extends InstanceContext
{
    protected $_verifications;
    protected $_verificationChecks;
    protected $_rateLimits;
    protected $_messagingConfigurations;
    protected $_entities;
    protected $_webhooks;
    protected $_accessTokens;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($sid) . '';
    }

    public function fetch(): ServiceInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ServiceInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $options = []): ServiceInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'CodeLength' => $options['codeLength'], 'LookupEnabled' => Serialize::booleanToString($options['lookupEnabled']), 'SkipSmsToLandlines' => Serialize::booleanToString($options['skipSmsToLandlines']), 'DtmfInputRequired' => Serialize::booleanToString($options['dtmfInputRequired']), 'TtsName' => $options['ttsName'], 'Psd2Enabled' => Serialize::booleanToString($options['psd2Enabled']), 'DoNotShareWarningEnabled' => Serialize::booleanToString($options['doNotShareWarningEnabled']), 'CustomCodeEnabled' => Serialize::booleanToString($options['customCodeEnabled']), 'Push.IncludeDate' => Serialize::booleanToString($options['pushIncludeDate']), 'Push.ApnCredentialSid' => $options['pushApnCredentialSid'], 'Push.FcmCredentialSid' => $options['pushFcmCredentialSid'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ServiceInstance($this->version, $payload, $this->solution['sid']);
    }

    protected function getVerifications(): VerificationList
    {
        if (!$this->_verifications) {
            $this->_verifications = new VerificationList($this->version, $this->solution['sid']);
        }
        return $this->_verifications;
    }

    protected function getVerificationChecks(): VerificationCheckList
    {
        if (!$this->_verificationChecks) {
            $this->_verificationChecks = new VerificationCheckList($this->version, $this->solution['sid']);
        }
        return $this->_verificationChecks;
    }

    protected function getRateLimits(): RateLimitList
    {
        if (!$this->_rateLimits) {
            $this->_rateLimits = new RateLimitList($this->version, $this->solution['sid']);
        }
        return $this->_rateLimits;
    }

    protected function getMessagingConfigurations(): MessagingConfigurationList
    {
        if (!$this->_messagingConfigurations) {
            $this->_messagingConfigurations = new MessagingConfigurationList($this->version, $this->solution['sid']);
        }
        return $this->_messagingConfigurations;
    }

    protected function getEntities(): EntityList
    {
        if (!$this->_entities) {
            $this->_entities = new EntityList($this->version, $this->solution['sid']);
        }
        return $this->_entities;
    }

    protected function getWebhooks(): WebhookList
    {
        if (!$this->_webhooks) {
            $this->_webhooks = new WebhookList($this->version, $this->solution['sid']);
        }
        return $this->_webhooks;
    }

    protected function getAccessTokens(): AccessTokenList
    {
        if (!$this->_accessTokens) {
            $this->_accessTokens = new AccessTokenList($this->version, $this->solution['sid']);
        }
        return $this->_accessTokens;
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
        return '[Twilio.Verify.V2.ServiceContext ' . implode(' ', $context) . ']';
    }
}