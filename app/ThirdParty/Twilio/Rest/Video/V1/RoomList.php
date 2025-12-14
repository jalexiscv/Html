<?php

namespace Twilio\Rest\Video\V1;

use Twilio\Exceptions\TwilioException;
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
        $this->uri = '/Rooms';
    }

    public function create(array $options = []): RoomInstance
    {
        $options = new Values($options);
        $data = Values::of(['EnableTurn' => Serialize::booleanToString($options['enableTurn']), 'Type' => $options['type'], 'UniqueName' => $options['uniqueName'], 'StatusCallback' => $options['statusCallback'], 'StatusCallbackMethod' => $options['statusCallbackMethod'], 'MaxParticipants' => $options['maxParticipants'], 'RecordParticipantsOnConnect' => Serialize::booleanToString($options['recordParticipantsOnConnect']), 'VideoCodecs' => Serialize::map($options['videoCodecs'], function ($e) {
            return $e;
        }), 'MediaRegion' => $options['mediaRegion'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new RoomInstance($this->version, $payload);
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
        $params = Values::of(['Status' => $options['status'], 'UniqueName' => $options['uniqueName'], 'DateCreatedAfter' => Serialize::iso8601DateTime($options['dateCreatedAfter']), 'DateCreatedBefore' => Serialize::iso8601DateTime($options['dateCreatedBefore']), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new RoomPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): RoomPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new RoomPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): RoomContext
    {
        return new RoomContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Video.V1.RoomList]';
    }
}