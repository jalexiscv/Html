<?php

namespace Twilio\Rest\Api\V2010\Account\Conference;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class RecordingList extends ListResource
{
    public function __construct(Version $version, string $accountSid, string $conferenceSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'conferenceSid' => $conferenceSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Conferences/' . rawurlencode($conferenceSid) . '/Recordings.json';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): RecordingPage
    {
        $options = new Values($options);
        $params = Values::of(['DateCreated<' => Serialize::iso8601Date($options['dateCreatedBefore']), 'DateCreated' => Serialize::iso8601Date($options['dateCreated']), 'DateCreated>' => Serialize::iso8601Date($options['dateCreatedAfter']), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new RecordingPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): RecordingPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new RecordingPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): RecordingContext
    {
        return new RecordingContext($this->version, $this->solution['accountSid'], $this->solution['conferenceSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.RecordingList]';
    }
}