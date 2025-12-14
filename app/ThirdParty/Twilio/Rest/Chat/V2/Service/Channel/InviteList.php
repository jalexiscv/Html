<?php

namespace Twilio\Rest\Chat\V2\Service\Channel;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class InviteList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $channelSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'channelSid' => $channelSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Channels/' . rawurlencode($channelSid) . '/Invites';
    }

    public function create(string $identity, array $options = []): InviteInstance
    {
        $options = new Values($options);
        $data = Values::of(['Identity' => $identity, 'RoleSid' => $options['roleSid'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new InviteInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['channelSid']);
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): InvitePage
    {
        $options = new Values($options);
        $params = Values::of(['Identity' => Serialize::map($options['identity'], function ($e) {
            return $e;
        }), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new InvitePage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): InvitePage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new InvitePage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): InviteContext
    {
        return new InviteContext($this->version, $this->solution['serviceSid'], $this->solution['channelSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Chat.V2.InviteList]';
    }
}