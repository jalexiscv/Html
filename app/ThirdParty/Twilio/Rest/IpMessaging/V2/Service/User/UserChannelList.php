<?php

namespace Twilio\Rest\IpMessaging\V2\Service\User;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class UserChannelList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $userSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'userSid' => $userSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Users/' . rawurlencode($userSid) . '/Channels';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): UserChannelPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new UserChannelPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): UserChannelPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new UserChannelPage($this->version, $response, $this->solution);
    }

    public function getContext(string $channelSid): UserChannelContext
    {
        return new UserChannelContext($this->version, $this->solution['serviceSid'], $this->solution['userSid'], $channelSid);
    }

    public function __toString(): string
    {
        return '[Twilio.IpMessaging.V2.UserChannelList]';
    }
}