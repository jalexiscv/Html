<?php

namespace Twilio\Rest\Proxy\V1\Service\Session\Participant;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class MessageInteractionList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $sessionSid, string $participantSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sessionSid' => $sessionSid, 'participantSid' => $participantSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Sessions/' . rawurlencode($sessionSid) . '/Participants/' . rawurlencode($participantSid) . '/MessageInteractions';
    }

    public function create(array $options = []): MessageInteractionInstance
    {
        $options = new Values($options);
        $data = Values::of(['Body' => $options['body'], 'MediaUrl' => Serialize::map($options['mediaUrl'], function ($e) {
            return $e;
        }),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new MessageInteractionInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sessionSid'], $this->solution['participantSid']);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): MessageInteractionPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new MessageInteractionPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): MessageInteractionPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new MessageInteractionPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): MessageInteractionContext
    {
        return new MessageInteractionContext($this->version, $this->solution['serviceSid'], $this->solution['sessionSid'], $this->solution['participantSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Proxy.V1.MessageInteractionList]';
    }
}