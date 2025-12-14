<?php

namespace Twilio\Rest\Video\V1;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class RecordingList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Recordings';
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
        $params = Values::of(['Status' => $options['status'], 'SourceSid' => $options['sourceSid'], 'GroupingSid' => Serialize::map($options['groupingSid'], function ($e) {
            return $e;
        }), 'DateCreatedAfter' => Serialize::iso8601DateTime($options['dateCreatedAfter']), 'DateCreatedBefore' => Serialize::iso8601DateTime($options['dateCreatedBefore']), 'MediaType' => $options['mediaType'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
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
        return new RecordingContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Video.V1.RecordingList]';
    }
}