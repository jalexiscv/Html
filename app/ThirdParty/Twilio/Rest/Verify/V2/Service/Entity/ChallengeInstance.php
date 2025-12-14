<?php

namespace Twilio\Rest\Verify\V2\Service\Entity;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ChallengeInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $identity, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'entitySid' => Values::array_get($payload, 'entity_sid'), 'identity' => Values::array_get($payload, 'identity'), 'factorSid' => Values::array_get($payload, 'factor_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'dateResponded' => Deserialize::dateTime(Values::array_get($payload, 'date_responded')), 'expirationDate' => Deserialize::dateTime(Values::array_get($payload, 'expiration_date')), 'status' => Values::array_get($payload, 'status'), 'respondedReason' => Values::array_get($payload, 'responded_reason'), 'details' => Values::array_get($payload, 'details'), 'hiddenDetails' => Values::array_get($payload, 'hidden_details'), 'factorType' => Values::array_get($payload, 'factor_type'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['serviceSid' => $serviceSid, 'identity' => $identity, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ChallengeContext
    {
        if (!$this->context) {
            $this->context = new ChallengeContext($this->version, $this->solution['serviceSid'], $this->solution['identity'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): ChallengeInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): ChallengeInstance
    {
        return $this->proxy()->update($options);
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
        return '[Twilio.Verify.V2.ChallengeInstance ' . implode(' ', $context) . ']';
    }
}