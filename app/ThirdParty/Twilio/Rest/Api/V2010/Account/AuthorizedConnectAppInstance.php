<?php

namespace Twilio\Rest\Api\V2010\Account;

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

class AuthorizedConnectAppInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid, string $connectAppSid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'connectAppCompanyName' => Values::array_get($payload, 'connect_app_company_name'), 'connectAppDescription' => Values::array_get($payload, 'connect_app_description'), 'connectAppFriendlyName' => Values::array_get($payload, 'connect_app_friendly_name'), 'connectAppHomepageUrl' => Values::array_get($payload, 'connect_app_homepage_url'), 'connectAppSid' => Values::array_get($payload, 'connect_app_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'permissions' => Values::array_get($payload, 'permissions'), 'uri' => Values::array_get($payload, 'uri'),];
        $this->solution = ['accountSid' => $accountSid, 'connectAppSid' => $connectAppSid ?: $this->properties['connectAppSid'],];
    }

    protected function proxy(): AuthorizedConnectAppContext
    {
        if (!$this->context) {
            $this->context = new AuthorizedConnectAppContext($this->version, $this->solution['accountSid'], $this->solution['connectAppSid']);
        }
        return $this->context;
    }

    public function fetch(): AuthorizedConnectAppInstance
    {
        return $this->proxy()->fetch();
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
        return '[Twilio.Api.V2010.AuthorizedConnectAppInstance ' . implode(' ', $context) . ']';
    }
}