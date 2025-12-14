<?php

namespace Twilio\Rest\Video\V1\Room;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
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
        $this->uri = '/Rooms/' . rawurlencode($roomSid) . '/Participants';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ParticipantPage
    {
        $options = new Values($options);
        $params = Values::of(['Status' => $options['status'], 'Identity' => $options['identity'], 'DateCreatedAfter' => Serialize::iso8601DateTime($options['dateCreatedAfter']), 'DateCreatedBefore' => Serialize::iso8601DateTime($options['dateCreatedBefore']), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ParticipantPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ParticipantPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ParticipantPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): ParticipantContext
    {
        return new ParticipantContext($this->version, $this->solution['roomSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Video.V1.ParticipantList]';
    }
}