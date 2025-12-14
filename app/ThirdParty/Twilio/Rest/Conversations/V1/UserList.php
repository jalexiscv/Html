<?php

namespace Twilio\Rest\Conversations\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class UserList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Users';
    }

    public function create(string $identity, array $options = []): UserInstance
    {
        $options = new Values($options);
        $data = Values::of(['Identity' => $identity, 'FriendlyName' => $options['friendlyName'], 'Attributes' => $options['attributes'], 'RoleSid' => $options['roleSid'],]);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data, $headers);
        return new UserInstance($this->version, $payload);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): UserPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new UserPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): UserPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new UserPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): UserContext
    {
        return new UserContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Conversations.V1.UserList]';
    }
}