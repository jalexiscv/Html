<?php

namespace Twilio\Rest\Proxy\V1\Service\Session;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class ParticipantList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $sessionSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sessionSid' => $sessionSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Sessions/' . rawurlencode($sessionSid) . '/Participants';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ParticipantPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ParticipantPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ParticipantPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ParticipantPage($this->version, $response, $this->solution);
    }

    public function create(string $identifier, array $options = []): ParticipantInstance
    {
        $options = new Values($options);
        $data = Values::of(['Identifier' => $identifier, 'FriendlyName' => $options['friendlyName'], 'ProxyIdentifier' => $options['proxyIdentifier'], 'ProxyIdentifierSid' => $options['proxyIdentifierSid'], 'FailOnParticipantConflict' => Serialize::booleanToString($options['failOnParticipantConflict']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ParticipantInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sessionSid']);
    }

    public function getContext(string $sid): ParticipantContext
    {
        return new ParticipantContext($this->version, $this->solution['serviceSid'], $this->solution['sessionSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Proxy.V1.ParticipantList]';
    }
}