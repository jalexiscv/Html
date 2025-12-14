<?php

namespace Twilio\Rest\Insights\V1;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class RoomList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Video/Rooms';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): RoomPage
    {
        $options = new Values($options);
        $params = Values::of(['RoomType' => Serialize::map($options['roomType'], function ($e) {
            return $e;
        }), 'Codec' => Serialize::map($options['codec'], function ($e) {
            return $e;
        }), 'RoomName' => $options['roomName'], 'CreatedAfter' => Serialize::iso8601DateTime($options['createdAfter']), 'CreatedBefore' => Serialize::iso8601DateTime($options['createdBefore']), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new RoomPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): RoomPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new RoomPage($this->version, $response, $this->solution);
    }

    public function getContext(string $roomSid): RoomContext
    {
        return new RoomContext($this->version, $roomSid);
    }

    public function __toString(): string
    {
        return '[Twilio.Insights.V1.RoomList]';
    }
}