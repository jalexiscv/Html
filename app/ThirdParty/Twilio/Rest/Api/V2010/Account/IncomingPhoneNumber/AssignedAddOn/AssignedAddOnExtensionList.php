<?php

namespace Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\AssignedAddOn;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class AssignedAddOnExtensionList extends ListResource
{
    public function __construct(Version $version, string $accountSid, string $resourceSid, string $assignedAddOnSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'resourceSid' => $resourceSid, 'assignedAddOnSid' => $assignedAddOnSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/IncomingPhoneNumbers/' . rawurlencode($resourceSid) . '/AssignedAddOns/' . rawurlencode($assignedAddOnSid) . '/Extensions.json';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): AssignedAddOnExtensionPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new AssignedAddOnExtensionPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): AssignedAddOnExtensionPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new AssignedAddOnExtensionPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): AssignedAddOnExtensionContext
    {
        return new AssignedAddOnExtensionContext($this->version, $this->solution['accountSid'], $this->solution['resourceSid'], $this->solution['assignedAddOnSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.AssignedAddOnExtensionList]';
    }
}