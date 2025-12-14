<?php

namespace Twilio\Rest\Voice\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class ConnectionPolicyList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/ConnectionPolicies';
    }

    public function create(array $options = []): ConnectionPolicyInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ConnectionPolicyInstance($this->version, $payload);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ConnectionPolicyPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ConnectionPolicyPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ConnectionPolicyPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ConnectionPolicyPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): ConnectionPolicyContext
    {
        return new ConnectionPolicyContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Voice.V1.ConnectionPolicyList]';
    }
}