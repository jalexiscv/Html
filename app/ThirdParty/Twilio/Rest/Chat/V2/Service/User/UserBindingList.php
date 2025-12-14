<?php

namespace Twilio\Rest\Chat\V2\Service\User;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class UserBindingList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $userSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'userSid' => $userSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Users/' . rawurlencode($userSid) . '/Bindings';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): UserBindingPage
    {
        $options = new Values($options);
        $params = Values::of(['BindingType' => Serialize::map($options['bindingType'], function ($e) {
            return $e;
        }), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new UserBindingPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): UserBindingPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new UserBindingPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): UserBindingContext
    {
        return new UserBindingContext($this->version, $this->solution['serviceSid'], $this->solution['userSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Chat.V2.UserBindingList]';
    }
}