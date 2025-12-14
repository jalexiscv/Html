<?php

namespace Twilio\Rest\Verify\V2;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Verify\V2\Service\AccessTokenList;
use Twilio\Rest\Verify\V2\Service\EntityList;
use Twilio\Rest\Verify\V2\Service\MessagingConfigurationList;
use Twilio\Rest\Verify\V2\Service\RateLimitList;
use Twilio\Rest\Verify\V2\Service\VerificationCheckList;
use Twilio\Rest\Verify\V2\Service\VerificationList;
use Twilio\Rest\Verify\V2\Service\WebhookList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ServiceInstance extends InstanceResource
{
    protected $_verifications;
    protected $_verificationChecks;
    protected $_rateLimits;
    protected $_messagingConfigurations;
    protected $_entities;
    protected $_webhooks;
    protected $_accessTokens;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'codeLength' => Values::array_get($payload, 'code_length'), 'lookupEnabled' => Values::array_get($payload, 'lookup_enabled'), 'psd2Enabled' => Values::array_get($payload, 'psd2_enabled'), 'skipSmsToLandlines' => Values::array_get($payload, 'skip_sms_to_landlines'), 'dtmfInputRequired' => Values::array_get($payload, 'dtmf_input_required'), 'ttsName' => Values::array_get($payload, 'tts_name'), 'doNotShareWarningEnabled' => Values::array_get($payload, 'do_not_share_warning_enabled'), 'customCodeEnabled' => Values::array_get($payload, 'custom_code_enabled'), 'push' => Values::array_get($payload, 'push'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ServiceContext
    {
        if (!$this->context) {
            $this->context = new ServiceContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): ServiceInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(array $options = []): ServiceInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getVerifications(): VerificationList
    {
        return $this->proxy()->verifications;
    }

    protected function getVerificationChecks(): VerificationCheckList
    {
        return $this->proxy()->verificationChecks;
    }

    protected function getRateLimits(): RateLimitList
    {
        return $this->proxy()->rateLimits;
    }

    protected function getMessagingConfigurations(): MessagingConfigurationList
    {
        return $this->proxy()->messagingConfigurations;
    }

    protected function getEntities(): EntityList
    {
        return $this->proxy()->entities;
    }

    protected function getWebhooks(): WebhookList
    {
        return $this->proxy()->webhooks;
    }

    protected function getAccessTokens(): AccessTokenList
    {
        return $this->proxy()->accessTokens;
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
        return '[Twilio.Verify.V2.ServiceInstance ' . implode(' ', $context) . ']';
    }
}