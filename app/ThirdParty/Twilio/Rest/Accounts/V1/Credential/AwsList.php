<?php

namespace Twilio\Rest\Accounts\V1\Credential;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class AwsList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Credentials/AWS';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): AwsPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new AwsPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): AwsPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new AwsPage($this->version, $response, $this->solution);
    }

    public function create(string $credentials, array $options = []): AwsInstance
    {
        $options = new Values($options);
        $data = Values::of(['Credentials' => $credentials, 'FriendlyName' => $options['friendlyName'], 'AccountSid' => $options['accountSid'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new AwsInstance($this->version, $payload);
    }

    public function getContext(string $sid): AwsContext
    {
        return new AwsContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Accounts.V1.AwsList]';
    }
}