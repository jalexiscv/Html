<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class NotificationList extends ListResource
{
    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Notifications.json';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): NotificationPage
    {
        $options = new Values($options);
        $params = Values::of(['Log' => $options['log'], 'MessageDate<' => Serialize::iso8601Date($options['messageDateBefore']), 'MessageDate' => Serialize::iso8601Date($options['messageDate']), 'MessageDate>' => Serialize::iso8601Date($options['messageDateAfter']), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new NotificationPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): NotificationPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new NotificationPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): NotificationContext
    {
        return new NotificationContext($this->version, $this->solution['accountSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.NotificationList]';
    }
}