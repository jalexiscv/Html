<?php

namespace Twilio\Rest\Conversations\V1\Service\Conversation;

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
    public function __construct(Version $version, string $chatServiceSid, string $conversationSid)
    {
        parent::__construct($version);
        $this->solution = ['chatServiceSid' => $chatServiceSid, 'conversationSid' => $conversationSid,];
        $this->uri = '/Services/' . rawurlencode($chatServiceSid) . '/Conversations/' . rawurlencode($conversationSid) . '/Participants';
    }

    public function create(array $options = []): ParticipantInstance
    {
        $options = new Values($options);
        $data = Values::of(['Identity' => $options['identity'], 'MessagingBinding.Address' => $options['messagingBindingAddress'], 'MessagingBinding.ProxyAddress' => $options['messagingBindingProxyAddress'], 'DateCreated' => Serialize::iso8601DateTime($options['dateCreated']), 'DateUpdated' => Serialize::iso8601DateTime($options['dateUpdated']), 'Attributes' => $options['attributes'], 'MessagingBinding.ProjectedAddress' => $options['messagingBindingProjectedAddress'], 'RoleSid' => $options['roleSid'],]);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data, $headers);
        return new ParticipantInstance($this->version, $payload, $this->solution['chatServiceSid'], $this->solution['conversationSid']);
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

    public function getContext(string $sid): ParticipantContext
    {
        return new ParticipantContext($this->version, $this->solution['chatServiceSid'], $this->solution['conversationSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Conversations.V1.ParticipantList]';
    }
}