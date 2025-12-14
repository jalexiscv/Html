<?php

namespace Twilio\Rest\Supersim\V1\NetworkAccessProfile;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class NetworkAccessProfileNetworkList extends ListResource
{
    public function __construct(Version $version, string $networkAccessProfileSid)
    {
        parent::__construct($version);
        $this->solution = ['networkAccessProfileSid' => $networkAccessProfileSid,];
        $this->uri = '/NetworkAccessProfiles/' . rawurlencode($networkAccessProfileSid) . '/Networks';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): NetworkAccessProfileNetworkPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new NetworkAccessProfileNetworkPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): NetworkAccessProfileNetworkPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new NetworkAccessProfileNetworkPage($this->version, $response, $this->solution);
    }

    public function create(string $network): NetworkAccessProfileNetworkInstance
    {
        $data = Values::of(['Network' => $network,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new NetworkAccessProfileNetworkInstance($this->version, $payload, $this->solution['networkAccessProfileSid']);
    }

    public function getContext(string $sid): NetworkAccessProfileNetworkContext
    {
        return new NetworkAccessProfileNetworkContext($this->version, $this->solution['networkAccessProfileSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Supersim.V1.NetworkAccessProfileNetworkList]';
    }
}