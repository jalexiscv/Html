<?php

namespace Twilio\Rest\Preview\Marketplace\AvailableAddOn;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class AvailableAddOnExtensionList extends ListResource
{
    public function __construct(Version $version, string $availableAddOnSid)
    {
        parent::__construct($version);
        $this->solution = ['availableAddOnSid' => $availableAddOnSid,];
        $this->uri = '/AvailableAddOns/' . rawurlencode($availableAddOnSid) . '/Extensions';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): AvailableAddOnExtensionPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new AvailableAddOnExtensionPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): AvailableAddOnExtensionPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new AvailableAddOnExtensionPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): AvailableAddOnExtensionContext
    {
        return new AvailableAddOnExtensionContext($this->version, $this->solution['availableAddOnSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Marketplace.AvailableAddOnExtensionList]';
    }
}