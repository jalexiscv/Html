<?php

namespace Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class AssignedAddOnList extends ListResource
{
    public function __construct(Version $version, string $accountSid, string $resourceSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'resourceSid' => $resourceSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/IncomingPhoneNumbers/' . rawurlencode($resourceSid) . '/AssignedAddOns.json';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): AssignedAddOnPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new AssignedAddOnPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): AssignedAddOnPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new AssignedAddOnPage($this->version, $response, $this->solution);
    }

    public function create(string $installedAddOnSid): AssignedAddOnInstance
    {
        $data = Values::of(['InstalledAddOnSid' => $installedAddOnSid,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new AssignedAddOnInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['resourceSid']);
    }

    public function getContext(string $sid): AssignedAddOnContext
    {
        return new AssignedAddOnContext($this->version, $this->solution['accountSid'], $this->solution['resourceSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.AssignedAddOnList]';
    }
}