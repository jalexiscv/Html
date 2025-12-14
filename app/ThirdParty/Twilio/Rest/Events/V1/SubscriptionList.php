<?php

namespace Twilio\Rest\Events\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class SubscriptionList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Subscriptions';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): SubscriptionPage
    {
        $options = new Values($options);
        $params = Values::of(['SinkSid' => $options['sinkSid'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new SubscriptionPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): SubscriptionPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new SubscriptionPage($this->version, $response, $this->solution);
    }

    public function create(string $description, string $sinkSid, array $types): SubscriptionInstance
    {
        $data = Values::of(['Description' => $description, 'SinkSid' => $sinkSid, 'Types' => Serialize::map($types, function ($e) {
            return Serialize::jsonObject($e);
        }),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new SubscriptionInstance($this->version, $payload);
    }

    public function getContext(string $sid): SubscriptionContext
    {
        return new SubscriptionContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Events.V1.SubscriptionList]';
    }
}