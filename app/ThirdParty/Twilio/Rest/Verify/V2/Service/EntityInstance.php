<?php

namespace Twilio\Rest\Verify\V2\Service;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Verify\V2\Service\Entity\ChallengeList;
use Twilio\Rest\Verify\V2\Service\Entity\FactorList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class EntityInstance extends InstanceResource
{
    protected $_factors;
    protected $_challenges;

    public function __construct(Version $version, array $payload, string $serviceSid, string $identity = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'identity' => Values::array_get($payload, 'identity'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['serviceSid' => $serviceSid, 'identity' => $identity ?: $this->properties['identity'],];
    }

    protected function proxy(): EntityContext
    {
        if (!$this->context) {
            $this->context = new EntityContext($this->version, $this->solution['serviceSid'], $this->solution['identity']);
        }
        return $this->context;
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function fetch(): EntityInstance
    {
        return $this->proxy()->fetch();
    }

    protected function getFactors(): FactorList
    {
        return $this->proxy()->factors;
    }

    protected function getChallenges(): ChallengeList
    {
        return $this->proxy()->challenges;
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
        return '[Twilio.Verify.V2.EntityInstance ' . implode(' ', $context) . ']';
    }
}