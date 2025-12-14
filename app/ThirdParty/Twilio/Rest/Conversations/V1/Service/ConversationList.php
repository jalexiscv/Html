<?php

namespace Twilio\Rest\Conversations\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class ConversationList extends ListResource
{
    public function __construct(Version $version, string $chatServiceSid)
    {
        parent::__construct($version);
        $this->solution = ['chatServiceSid' => $chatServiceSid,];
        $this->uri = '/Services/' . rawurlencode($chatServiceSid) . '/Conversations';
    }

    public function create(array $options = []): ConversationInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'UniqueName' => $options['uniqueName'], 'Attributes' => $options['attributes'], 'MessagingServiceSid' => $options['messagingServiceSid'], 'DateCreated' => Serialize::iso8601DateTime($options['dateCreated']), 'DateUpdated' => Serialize::iso8601DateTime($options['dateUpdated']), 'State' => $options['state'], 'Timers.Inactive' => $options['timersInactive'], 'Timers.Closed' => $options['timersClosed'],]);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data, $headers);
        return new ConversationInstance($this->version, $payload, $this->solution['chatServiceSid']);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ConversationPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ConversationPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ConversationPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ConversationPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): ConversationContext
    {
        return new ConversationContext($this->version, $this->solution['chatServiceSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Conversations.V1.ConversationList]';
    }
}