<?php

namespace Twilio\Rest\Api\V2010;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class AccountList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Accounts.json';
    }

    public function create(array $options = []): AccountInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new AccountInstance($this->version, $payload);
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): AccountPage
    {
        $options = new Values($options);
        $params = Values::of(['FriendlyName' => $options['friendlyName'], 'Status' => $options['status'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new AccountPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): AccountPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new AccountPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): AccountContext
    {
        return new AccountContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.AccountList]';
    }
}