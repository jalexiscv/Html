<?php

namespace Twilio\Rest\Preview\Marketplace\InstalledAddOn;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class InstalledAddOnExtensionList extends ListResource
{
    public function __construct(Version $version, string $installedAddOnSid)
    {
        parent::__construct($version);
        $this->solution = ['installedAddOnSid' => $installedAddOnSid,];
        $this->uri = '/InstalledAddOns/' . rawurlencode($installedAddOnSid) . '/Extensions';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): InstalledAddOnExtensionPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new InstalledAddOnExtensionPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): InstalledAddOnExtensionPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new InstalledAddOnExtensionPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): InstalledAddOnExtensionContext
    {
        return new InstalledAddOnExtensionContext($this->version, $this->solution['installedAddOnSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Marketplace.InstalledAddOnExtensionList]';
    }
}