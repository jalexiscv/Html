<?php

namespace Twilio\Rest\Api\V2010;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Api\V2010\Account\AddressList;
use Twilio\Rest\Api\V2010\Account\ApplicationList;
use Twilio\Rest\Api\V2010\Account\AuthorizedConnectAppList;
use Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountryList;
use Twilio\Rest\Api\V2010\Account\BalanceList;
use Twilio\Rest\Api\V2010\Account\CallList;
use Twilio\Rest\Api\V2010\Account\ConferenceList;
use Twilio\Rest\Api\V2010\Account\ConnectAppList;
use Twilio\Rest\Api\V2010\Account\IncomingPhoneNumberList;
use Twilio\Rest\Api\V2010\Account\KeyList;
use Twilio\Rest\Api\V2010\Account\MessageList;
use Twilio\Rest\Api\V2010\Account\NewKeyList;
use Twilio\Rest\Api\V2010\Account\NewSigningKeyList;
use Twilio\Rest\Api\V2010\Account\NotificationList;
use Twilio\Rest\Api\V2010\Account\OutgoingCallerIdList;
use Twilio\Rest\Api\V2010\Account\QueueList;
use Twilio\Rest\Api\V2010\Account\RecordingList;
use Twilio\Rest\Api\V2010\Account\ShortCodeList;
use Twilio\Rest\Api\V2010\Account\SigningKeyList;
use Twilio\Rest\Api\V2010\Account\SipList;
use Twilio\Rest\Api\V2010\Account\TokenList;
use Twilio\Rest\Api\V2010\Account\TranscriptionList;
use Twilio\Rest\Api\V2010\Account\UsageList;
use Twilio\Rest\Api\V2010\Account\ValidationRequestList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class AccountInstance extends InstanceResource
{
    protected $_addresses;
    protected $_applications;
    protected $_authorizedConnectApps;
    protected $_availablePhoneNumbers;
    protected $_balance;
    protected $_calls;
    protected $_conferences;
    protected $_connectApps;
    protected $_incomingPhoneNumbers;
    protected $_keys;
    protected $_messages;
    protected $_newKeys;
    protected $_newSigningKeys;
    protected $_notifications;
    protected $_outgoingCallerIds;
    protected $_queues;
    protected $_recordings;
    protected $_signingKeys;
    protected $_sip;
    protected $_shortCodes;
    protected $_tokens;
    protected $_transcriptions;
    protected $_usage;
    protected $_validationRequests;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['authToken' => Values::array_get($payload, 'auth_token'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'ownerAccountSid' => Values::array_get($payload, 'owner_account_sid'), 'sid' => Values::array_get($payload, 'sid'), 'status' => Values::array_get($payload, 'status'), 'subresourceUris' => Values::array_get($payload, 'subresource_uris'), 'type' => Values::array_get($payload, 'type'), 'uri' => Values::array_get($payload, 'uri'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    public function fetch(): AccountInstance
    {
        return $this->proxy()->fetch();
    }

    protected function proxy(): AccountContext
    {
        if (!$this->context) {
            $this->context = new AccountContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function update(array $options = []): AccountInstance
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
        return '[Twilio.Api.V2010.AccountInstance ' . implode(' ', $context) . ']';
    }

    protected function getAddresses(): AddressList
    {
        return $this->proxy()->addresses;
    }

    protected function getApplications(): ApplicationList
    {
        return $this->proxy()->applications;
    }

    protected function getAuthorizedConnectApps(): AuthorizedConnectAppList
    {
        return $this->proxy()->authorizedConnectApps;
    }

    protected function getAvailablePhoneNumbers(): AvailablePhoneNumberCountryList
    {
        return $this->proxy()->availablePhoneNumbers;
    }

    protected function getBalance(): BalanceList
    {
        return $this->proxy()->balance;
    }

    protected function getCalls(): CallList
    {
        return $this->proxy()->calls;
    }

    protected function getConferences(): ConferenceList
    {
        return $this->proxy()->conferences;
    }

    protected function getConnectApps(): ConnectAppList
    {
        return $this->proxy()->connectApps;
    }

    protected function getIncomingPhoneNumbers(): IncomingPhoneNumberList
    {
        return $this->proxy()->incomingPhoneNumbers;
    }

    protected function getKeys(): KeyList
    {
        return $this->proxy()->keys;
    }

    protected function getMessages(): MessageList
    {
        return $this->proxy()->messages;
    }

    protected function getNewKeys(): NewKeyList
    {
        return $this->proxy()->newKeys;
    }

    protected function getNewSigningKeys(): NewSigningKeyList
    {
        return $this->proxy()->newSigningKeys;
    }

    protected function getNotifications(): NotificationList
    {
        return $this->proxy()->notifications;
    }

    protected function getOutgoingCallerIds(): OutgoingCallerIdList
    {
        return $this->proxy()->outgoingCallerIds;
    }

    protected function getQueues(): QueueList
    {
        return $this->proxy()->queues;
    }

    protected function getRecordings(): RecordingList
    {
        return $this->proxy()->recordings;
    }

    protected function getSigningKeys(): SigningKeyList
    {
        return $this->proxy()->signingKeys;
    }

    protected function getSip(): SipList
    {
        return $this->proxy()->sip;
    }

    protected function getShortCodes(): ShortCodeList
    {
        return $this->proxy()->shortCodes;
    }

    protected function getTokens(): TokenList
    {
        return $this->proxy()->tokens;
    }

    protected function getTranscriptions(): TranscriptionList
    {
        return $this->proxy()->transcriptions;
    }

    protected function getUsage(): UsageList
    {
        return $this->proxy()->usage;
    }

    protected function getValidationRequests(): ValidationRequestList
    {
        return $this->proxy()->validationRequests;
    }
}