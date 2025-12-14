<?php

namespace Twilio\Rest\Api\V2010\Account\Address;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class DependentPhoneNumberList extends ListResource
{
    public function __construct(Version $version, string $accountSid, string $addressSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'addressSid' => $addressSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Addresses/' . rawurlencode($addressSid) . '/DependentPhoneNumbers.json';
    }

    public function stream(int $limit = null, $pageSize = null): Stream
    {
        $limits = $this->version->readLimits($limit, $pageSize);
        $page = $this->page($limits['pageSize']);
        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    public function read(int $limit = null, $pageSize = null): array
    {
        return iterator_to_array($this->stream($limit, $pageSize), false);
    }

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): DependentPhoneNumberPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new DependentPhoneNumberPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): DependentPhoneNumberPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new DependentPhoneNumberPage($this->version, $response, $this->solution);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.DependentPhoneNumberList]';
    }
}