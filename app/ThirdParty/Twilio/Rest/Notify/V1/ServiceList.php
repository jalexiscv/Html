<?php

namespace Twilio\Rest\Notify\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class ServiceList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Services';
    }

    public function create(array $options = []): ServiceInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'ApnCredentialSid' => $options['apnCredentialSid'], 'GcmCredentialSid' => $options['gcmCredentialSid'], 'MessagingServiceSid' => $options['messagingServiceSid'], 'FacebookMessengerPageId' => $options['facebookMessengerPageId'], 'DefaultApnNotificationProtocolVersion' => $options['defaultApnNotificationProtocolVersion'], 'DefaultGcmNotificationProtocolVersion' => $options['defaultGcmNotificationProtocolVersion'], 'FcmCredentialSid' => $options['fcmCredentialSid'], 'DefaultFcmNotificationProtocolVersion' => $options['defaultFcmNotificationProtocolVersion'], 'LogEnabled' => Serialize::booleanToString($options['logEnabled']), 'AlexaSkillId' => $options['alexaSkillId'], 'DefaultAlexaNotificationProtocolVersion' => $options['defaultAlexaNotificationProtocolVersion'], 'DeliveryCallbackUrl' => $options['deliveryCallbackUrl'], 'DeliveryCallbackEnabled' => Serialize::booleanToString($options['deliveryCallbackEnabled']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ServiceInstance($this->version, $payload);
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ServicePage
    {
        $options = new Values($options);
        $params = Values::of(['FriendlyName' => $options['friendlyName'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ServicePage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ServicePage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ServicePage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): ServiceContext
    {
        return new ServiceContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Notify.V1.ServiceList]';
    }
}