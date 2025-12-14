<?php

namespace Twilio\Rest\Video\V1\Room\Participant;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class PublishedTrackList extends ListResource
{
    public function __construct(Version $version, string $roomSid, string $participantSid)
    {
        parent::__construct($version);
        $this->solution = ['roomSid' => $roomSid, 'participantSid' => $participantSid,];
        $this->uri = '/Rooms/' . rawurlencode($roomSid) . '/Participants/' . rawurlencode($participantSid) . '/PublishedTracks';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): PublishedTrackPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new PublishedTrackPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): PublishedTrackPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new PublishedTrackPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): PublishedTrackContext
    {
        return new PublishedTrackContext($this->version, $this->solution['roomSid'], $this->solution['participantSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Video.V1.PublishedTrackList]';
    }
}