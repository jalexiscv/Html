<?php

namespace Twilio\Rest\Insights\V1\Room;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class ParticipantList extends ListResource
{
    public function __construct(Version $version, string $roomSid)
    {
        parent::__construct($version);
        $this->solution = ['roomSid' => $roomSid,];
        $this->uri = '/Video/Rooms/' . rawurlencode($roomSid) . '/Participants';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ParticipantPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ParticipantPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ParticipantPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ParticipantPage($this->version, $response, $this->solution);
    }

    public function getContext(string $participantSid): ParticipantContext
    {
        return new ParticipantContext($this->version, $this->solution['roomSid'], $participantSid);
    }

    public function __toString(): string
    {
        return '[Twilio.Insights.V1.ParticipantList]';
    }
}