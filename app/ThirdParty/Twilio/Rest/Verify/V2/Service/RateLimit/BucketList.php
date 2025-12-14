<?php

namespace Twilio\Rest\Verify\V2\Service\RateLimit;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class BucketList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $rateLimitSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'rateLimitSid' => $rateLimitSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/RateLimits/' . rawurlencode($rateLimitSid) . '/Buckets';
    }

    public function create(int $max, int $interval): BucketInstance
    {
        $data = Values::of(['Max' => $max, 'Interval' => $interval,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new BucketInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['rateLimitSid']);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): BucketPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new BucketPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): BucketPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new BucketPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): BucketContext
    {
        return new BucketContext($this->version, $this->solution['serviceSid'], $this->solution['rateLimitSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Verify.V2.BucketList]';
    }
}