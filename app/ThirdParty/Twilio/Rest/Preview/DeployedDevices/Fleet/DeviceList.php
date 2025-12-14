<?php

namespace Twilio\Rest\Preview\DeployedDevices\Fleet;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class DeviceList extends ListResource
{
    public function __construct(Version $version, string $fleetSid)
    {
        parent::__construct($version);
        $this->solution = ['fleetSid' => $fleetSid,];
        $this->uri = '/Fleets/' . rawurlencode($fleetSid) . '/Devices';
    }

    public function create(array $options = []): DeviceInstance
    {
        $options = new Values($options);
        $data = Values::of(['UniqueName' => $options['uniqueName'], 'FriendlyName' => $options['friendlyName'], 'Identity' => $options['identity'], 'DeploymentSid' => $options['deploymentSid'], 'Enabled' => Serialize::booleanToString($options['enabled']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new DeviceInstance($this->version, $payload, $this->solution['fleetSid']);
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): DevicePage
    {
        $options = new Values($options);
        $params = Values::of(['DeploymentSid' => $options['deploymentSid'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new DevicePage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): DevicePage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new DevicePage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): DeviceContext
    {
        return new DeviceContext($this->version, $this->solution['fleetSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.DeployedDevices.DeviceList]';
    }
}