<?php

namespace Twilio\Rest\Events\V1\Subscription;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class SubscribedEventList extends ListResource
{
    public function __construct(Version $version, string $subscriptionSid)
    {
        parent::__construct($version);
        $this->solution = ['subscriptionSid' => $subscriptionSid,];
        $this->uri = '/Subscriptions/' . rawurlencode($subscriptionSid) . '/SubscribedEvents';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): SubscribedEventPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new SubscribedEventPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): SubscribedEventPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new SubscribedEventPage($this->version, $response, $this->solution);
    }

    public function __toString(): string
    {
        return '[Twilio.Events.V1.SubscribedEventList]';
    }
}