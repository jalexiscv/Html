<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class OutgoingCallerIdList extends ListResource
{
    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/OutgoingCallerIds.json';
    }

    public function stream(array $options = [], int $limit = null, $pageSize = null): Stream
    {
        $limits = $this->version->readLimits($limit, $pageSize);
        $page = $this->page($options, $limits['pageSize']);
        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    public function read(array $options = [], int $limit = null, $pageSize = null): array
    {
        return iterator_to_array($this->stream($options, $limit, $pageSize), false);
    }

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): OutgoingCallerIdPage
    {
        $options = new Values($options);
        $params = Values::of(['PhoneNumber' => $options['phoneNumber'], 'FriendlyName' => $options['friendlyName'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new OutgoingCallerIdPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): OutgoingCallerIdPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new OutgoingCallerIdPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): OutgoingCallerIdContext
    {
        return new OutgoingCallerIdContext($this->version, $this->solution['accountSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.OutgoingCallerIdList]';
    }
}