<?php

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance\Bundle;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class ItemAssignmentList extends ListResource
{
    public function __construct(Version $version, string $bundleSid)
    {
        parent::__construct($version);
        $this->solution = ['bundleSid' => $bundleSid,];
        $this->uri = '/RegulatoryCompliance/Bundles/' . rawurlencode($bundleSid) . '/ItemAssignments';
    }

    public function create(string $objectSid): ItemAssignmentInstance
    {
        $data = Values::of(['ObjectSid' => $objectSid,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ItemAssignmentInstance($this->version, $payload, $this->solution['bundleSid']);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ItemAssignmentPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ItemAssignmentPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ItemAssignmentPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ItemAssignmentPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): ItemAssignmentContext
    {
        return new ItemAssignmentContext($this->version, $this->solution['bundleSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Numbers.V2.ItemAssignmentList]';
    }
}