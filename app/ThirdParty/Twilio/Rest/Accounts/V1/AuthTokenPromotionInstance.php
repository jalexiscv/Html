<?php

namespace Twilio\Rest\Accounts\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class AuthTokenPromotionInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'authToken' => Values::array_get($payload, 'auth_token'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = [];
    }

    protected function proxy(): AuthTokenPromotionContext
    {
        if (!$this->context) {
            $this->context = new AuthTokenPromotionContext($this->version);
        }
        return $this->context;
    }

    public function update(): AuthTokenPromotionInstance
    {
        return $this->proxy()->update();
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
        return '[Twilio.Accounts.V1.AuthTokenPromotionInstance ' . implode(' ', $context) . ']';
    }
}