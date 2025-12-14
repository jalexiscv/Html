<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class MessageList extends ListResource
{
    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Messages.json';
    }

    public function create(string $to, array $options = []): MessageInstance
    {
        $options = new Values($options);
        $data = Values::of(['To' => $to, 'From' => $options['from'], 'MessagingServiceSid' => $options['messagingServiceSid'], 'Body' => $options['body'], 'MediaUrl' => Serialize::map($options['mediaUrl'], function ($e) {
            return $e;
        }), 'StatusCallback' => $options['statusCallback'], 'ApplicationSid' => $options['applicationSid'], 'MaxPrice' => $options['maxPrice'], 'ProvideFeedback' => Serialize::booleanToString($options['provideFeedback']), 'Attempt' => $options['attempt'], 'ValidityPeriod' => $options['validityPeriod'], 'ForceDelivery' => Serialize::booleanToString($options['forceDelivery']), 'ContentRetention' => $options['contentRetention'], 'AddressRetention' => $options['addressRetention'], 'SmartEncoded' => Serialize::booleanToString($options['smartEncoded']), 'PersistentAction' => Serialize::map($options['persistentAction'], function ($e) {
            return $e;
        }),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new MessageInstance($this->version, $payload, $this->solution['accountSid']);
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): MessagePage
    {
        $options = new Values($options);
        $params = Values::of(['To' => $options['to'], 'From' => $options['from'], 'DateSent<' => Serialize::iso8601DateTime($options['dateSentBefore']), 'DateSent' => Serialize::iso8601DateTime($options['dateSent']), 'DateSent>' => Serialize::iso8601DateTime($options['dateSentAfter']), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new MessagePage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): MessagePage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new MessagePage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): MessageContext
    {
        return new MessageContext($this->version, $this->solution['accountSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.MessageList]';
    }
}