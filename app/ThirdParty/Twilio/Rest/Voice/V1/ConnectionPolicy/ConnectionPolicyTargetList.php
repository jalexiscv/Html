<?php

namespace Twilio\Rest\Voice\V1\ConnectionPolicy;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class ConnectionPolicyTargetList extends ListResource
{
    public function __construct(Version $version, string $connectionPolicySid)
    {
        parent::__construct($version);
        $this->solution = ['connectionPolicySid' => $connectionPolicySid,];
        $this->uri = '/ConnectionPolicies/' . rawurlencode($connectionPolicySid) . '/Targets';
    }

    public function create(string $target, array $options = []): ConnectionPolicyTargetInstance
    {
        $options = new Values($options);
        $data = Values::of(['Target' => $target, 'FriendlyName' => $options['friendlyName'], 'Priority' => $options['priority'], 'Weight' => $options['weight'], 'Enabled' => Serialize::booleanToString($options['enabled']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ConnectionPolicyTargetInstance($this->version, $payload, $this->solution['connectionPolicySid']);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ConnectionPolicyTargetPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ConnectionPolicyTargetPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ConnectionPolicyTargetPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ConnectionPolicyTargetPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): ConnectionPolicyTargetContext
    {
        return new ConnectionPolicyTargetContext($this->version, $this->solution['connectionPolicySid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Voice.V1.ConnectionPolicyTargetList]';
    }
}