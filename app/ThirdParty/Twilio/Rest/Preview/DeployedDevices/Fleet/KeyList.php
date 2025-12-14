<?php

namespace Twilio\Rest\Preview\DeployedDevices\Fleet;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class KeyList extends ListResource
{
    public function __construct(Version $version, string $fleetSid)
    {
        parent::__construct($version);
        $this->solution = ['fleetSid' => $fleetSid,];
        $this->uri = '/Fleets/' . rawurlencode($fleetSid) . '/Keys';
    }

    public function create(array $options = []): KeyInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'DeviceSid' => $options['deviceSid'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new KeyInstance($this->version, $payload, $this->solution['fleetSid']);
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): KeyPage
    {
        $options = new Values($options);
        $params = Values::of(['DeviceSid' => $options['deviceSid'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new KeyPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): KeyPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new KeyPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): KeyContext
    {
        return new KeyContext($this->version, $this->solution['fleetSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.DeployedDevices.KeyList]';
    }
}