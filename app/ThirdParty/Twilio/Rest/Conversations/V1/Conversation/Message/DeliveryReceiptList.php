<?php

namespace Twilio\Rest\Conversations\V1\Conversation\Message;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class DeliveryReceiptList extends ListResource
{
    public function __construct(Version $version, string $conversationSid, string $messageSid)
    {
        parent::__construct($version);
        $this->solution = ['conversationSid' => $conversationSid, 'messageSid' => $messageSid,];
        $this->uri = '/Conversations/' . rawurlencode($conversationSid) . '/Messages/' . rawurlencode($messageSid) . '/Receipts';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): DeliveryReceiptPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new DeliveryReceiptPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): DeliveryReceiptPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new DeliveryReceiptPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): DeliveryReceiptContext
    {
        return new DeliveryReceiptContext($this->version, $this->solution['conversationSid'], $this->solution['messageSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Conversations.V1.DeliveryReceiptList]';
    }
}