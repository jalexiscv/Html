<?php

namespace Twilio\Rest\Fax\V1\Fax;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class FaxMediaList extends ListResource
{
    public function __construct(Version $version, string $faxSid)
    {
        parent::__construct($version);
        $this->solution = ['faxSid' => $faxSid,];
        $this->uri = '/Faxes/' . rawurlencode($faxSid) . '/Media';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): FaxMediaPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new FaxMediaPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): FaxMediaPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new FaxMediaPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): FaxMediaContext
    {
        return new FaxMediaContext($this->version, $this->solution['faxSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Fax.V1.FaxMediaList]';
    }
}