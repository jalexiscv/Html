<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class ConferenceList extends ListResource
{
    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Conferences.json';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ConferencePage
    {
        $options = new Values($options);
        $params = Values::of(['DateCreated<' => Serialize::iso8601Date($options['dateCreatedBefore']), 'DateCreated' => Serialize::iso8601Date($options['dateCreated']), 'DateCreated>' => Serialize::iso8601Date($options['dateCreatedAfter']), 'DateUpdated<' => Serialize::iso8601Date($options['dateUpdatedBefore']), 'DateUpdated' => Serialize::iso8601Date($options['dateUpdated']), 'DateUpdated>' => Serialize::iso8601Date($options['dateUpdatedAfter']), 'FriendlyName' => $options['friendlyName'], 'Status' => $options['status'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ConferencePage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ConferencePage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ConferencePage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): ConferenceContext
    {
        return new ConferenceContext($this->version, $this->solution['accountSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.ConferenceList]';
    }
}