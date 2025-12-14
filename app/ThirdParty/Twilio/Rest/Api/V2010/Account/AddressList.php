<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class AddressList extends ListResource
{
    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Addresses.json';
    }

    public function create(string $customerName, string $street, string $city, string $region, string $postalCode, string $isoCountry, array $options = []): AddressInstance
    {
        $options = new Values($options);
        $data = Values::of(['CustomerName' => $customerName, 'Street' => $street, 'City' => $city, 'Region' => $region, 'PostalCode' => $postalCode, 'IsoCountry' => $isoCountry, 'FriendlyName' => $options['friendlyName'], 'EmergencyEnabled' => Serialize::booleanToString($options['emergencyEnabled']), 'AutoCorrectAddress' => Serialize::booleanToString($options['autoCorrectAddress']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new AddressInstance($this->version, $payload, $this->solution['accountSid']);
    }

    public function read(array $options = [], int $limit = null, $pageSize = null): array
    {
        return iterator_to_array($this->stream($options, $limit, $pageSize), false);
    }

    public function stream(array $options = [], int $limit = null, $pageSize = null): Stream
    {
        $limits = $this->version->readLimits($limit, $pageSize);
        $page = $this->page($options, $limits['pageSize']);
        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): AddressPage
    {
        $options = new Values($options);
        $params = Values::of(['CustomerName' => $options['customerName'], 'FriendlyName' => $options['friendlyName'], 'IsoCountry' => $options['isoCountry'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new AddressPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): AddressPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new AddressPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): AddressContext
    {
        return new AddressContext($this->version, $this->solution['accountSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.AddressList]';
    }
}