<?php

namespace Twilio\Rest\Api\V2010\Account\Message;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class MediaList extends ListResource
{
    public function __construct(Version $version, string $accountSid, string $messageSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'messageSid' => $messageSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Messages/' . rawurlencode($messageSid) . '/Media.json';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): MediaPage
    {
        $options = new Values($options);
        $params = Values::of(['DateCreated<' => Serialize::iso8601DateTime($options['dateCreatedBefore']), 'DateCreated' => Serialize::iso8601DateTime($options['dateCreated']), 'DateCreated>' => Serialize::iso8601DateTime($options['dateCreatedAfter']), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new MediaPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): MediaPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new MediaPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): MediaContext
    {
        return new MediaContext($this->version, $this->solution['accountSid'], $this->solution['messageSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.MediaList]';
    }
}