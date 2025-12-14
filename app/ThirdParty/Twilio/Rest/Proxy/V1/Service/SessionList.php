<?php

namespace Twilio\Rest\Proxy\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class SessionList extends ListResource
{
    public function __construct(Version $version, string $serviceSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Sessions';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): SessionPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new SessionPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): SessionPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new SessionPage($this->version, $response, $this->solution);
    }

    public function create(array $options = []): SessionInstance
    {
        $options = new Values($options);
        $data = Values::of(['UniqueName' => $options['uniqueName'], 'DateExpiry' => Serialize::iso8601DateTime($options['dateExpiry']), 'Ttl' => $options['ttl'], 'Mode' => $options['mode'], 'Status' => $options['status'], 'Participants' => Serialize::map($options['participants'], function ($e) {
            return Serialize::jsonObject($e);
        }), 'FailOnParticipantConflict' => Serialize::booleanToString($options['failOnParticipantConflict']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new SessionInstance($this->version, $payload, $this->solution['serviceSid']);
    }

    public function getContext(string $sid): SessionContext
    {
        return new SessionContext($this->version, $this->solution['serviceSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Proxy.V1.SessionList]';
    }
}