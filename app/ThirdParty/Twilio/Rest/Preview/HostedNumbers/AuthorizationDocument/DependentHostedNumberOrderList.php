<?php

namespace Twilio\Rest\Preview\HostedNumbers\AuthorizationDocument;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class DependentHostedNumberOrderList extends ListResource
{
    public function __construct(Version $version, string $signingDocumentSid)
    {
        parent::__construct($version);
        $this->solution = ['signingDocumentSid' => $signingDocumentSid,];
        $this->uri = '/AuthorizationDocuments/' . rawurlencode($signingDocumentSid) . '/DependentHostedNumberOrders';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): DependentHostedNumberOrderPage
    {
        $options = new Values($options);
        $params = Values::of(['Status' => $options['status'], 'PhoneNumber' => $options['phoneNumber'], 'IncomingPhoneNumberSid' => $options['incomingPhoneNumberSid'], 'FriendlyName' => $options['friendlyName'], 'UniqueName' => $options['uniqueName'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new DependentHostedNumberOrderPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): DependentHostedNumberOrderPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new DependentHostedNumberOrderPage($this->version, $response, $this->solution);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.HostedNumbers.DependentHostedNumberOrderList]';
    }
}