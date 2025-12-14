<?php

namespace Twilio\Rest\Preview\HostedNumbers;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class AuthorizationDocumentList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/AuthorizationDocuments';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): AuthorizationDocumentPage
    {
        $options = new Values($options);
        $params = Values::of(['Email' => $options['email'], 'Status' => $options['status'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new AuthorizationDocumentPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): AuthorizationDocumentPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new AuthorizationDocumentPage($this->version, $response, $this->solution);
    }

    public function create(array $hostedNumberOrderSids, string $addressSid, string $email, string $contactTitle, string $contactPhoneNumber, array $options = []): AuthorizationDocumentInstance
    {
        $options = new Values($options);
        $data = Values::of(['HostedNumberOrderSids' => Serialize::map($hostedNumberOrderSids, function ($e) {
            return $e;
        }), 'AddressSid' => $addressSid, 'Email' => $email, 'ContactTitle' => $contactTitle, 'ContactPhoneNumber' => $contactPhoneNumber, 'CcEmails' => Serialize::map($options['ccEmails'], function ($e) {
            return $e;
        }),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new AuthorizationDocumentInstance($this->version, $payload);
    }

    public function getContext(string $sid): AuthorizationDocumentContext
    {
        return new AuthorizationDocumentContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.HostedNumbers.AuthorizationDocumentList]';
    }
}