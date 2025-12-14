<?php

namespace Twilio\Rest\Verify\V2\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class RateLimitList extends ListResource
{
    public function __construct(Version $version, string $serviceSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/RateLimits';
    }

    public function create(string $uniqueName, array $options = []): RateLimitInstance
    {
        $options = new Values($options);
        $data = Values::of(['UniqueName' => $uniqueName, 'Description' => $options['description'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new RateLimitInstance($this->version, $payload, $this->solution['serviceSid']);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): RateLimitPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new RateLimitPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): RateLimitPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new RateLimitPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): RateLimitContext
    {
        return new RateLimitContext($this->version, $this->solution['serviceSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Verify.V2.RateLimitList]';
    }
}