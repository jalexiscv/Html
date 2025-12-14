<?php

namespace Twilio\Rest\Proxy\V1\Service\Session;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class InteractionList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $sessionSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sessionSid' => $sessionSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Sessions/' . rawurlencode($sessionSid) . '/Interactions';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): InteractionPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new InteractionPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): InteractionPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new InteractionPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): InteractionContext
    {
        return new InteractionContext($this->version, $this->solution['serviceSid'], $this->solution['sessionSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Proxy.V1.InteractionList]';
    }
}