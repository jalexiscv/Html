<?php

namespace Twilio\Rest\Trunking\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Trunking\V1\Trunk\CredentialListList;
use Twilio\Rest\Trunking\V1\Trunk\IpAccessControlListList;
use Twilio\Rest\Trunking\V1\Trunk\OriginationUrlList;
use Twilio\Rest\Trunking\V1\Trunk\PhoneNumberList;
use Twilio\Rest\Trunking\V1\Trunk\RecordingList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class TrunkInstance extends InstanceResource
{
    protected $_originationUrls;
    protected $_credentialsLists;
    protected $_ipAccessControlLists;
    protected $_phoneNumbers;
    protected $_recordings;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'domainName' => Values::array_get($payload, 'domain_name'), 'disasterRecoveryMethod' => Values::array_get($payload, 'disaster_recovery_method'), 'disasterRecoveryUrl' => Values::array_get($payload, 'disaster_recovery_url'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'secure' => Values::array_get($payload, 'secure'), 'recording' => Values::array_get($payload, 'recording'), 'transferMode' => Values::array_get($payload, 'transfer_mode'), 'cnamLookupEnabled' => Values::array_get($payload, 'cnam_lookup_enabled'), 'authType' => Values::array_get($payload, 'auth_type'), 'authTypeSet' => Values::array_get($payload, 'auth_type_set'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'sid' => Values::array_get($payload, 'sid'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): TrunkContext
    {
        if (!$this->context) {
            $this->context = new TrunkContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): TrunkInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(array $options = []): TrunkInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getOriginationUrls(): OriginationUrlList
    {
        return $this->proxy()->originationUrls;
    }

    protected function getCredentialsLists(): CredentialListList
    {
        return $this->proxy()->credentialsLists;
    }

    protected function getIpAccessControlLists(): IpAccessControlListList
    {
        return $this->proxy()->ipAccessControlLists;
    }

    protected function getPhoneNumbers(): PhoneNumberList
    {
        return $this->proxy()->phoneNumbers;
    }

    protected function getRecordings(): RecordingList
    {
        return $this->proxy()->recordings;
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
        return '[Twilio.Trunking.V1.TrunkInstance ' . implode(' ', $context) . ']';
    }
}