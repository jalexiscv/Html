<?php

namespace Twilio\Rest\Api\V2010\Account\Recording;

use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class TranscriptionList extends ListResource
{
    public function __construct(Version $version, string $accountSid, string $recordingSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'recordingSid' => $recordingSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Recordings/' . rawurlencode($recordingSid) . '/Transcriptions.json';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): TranscriptionPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new TranscriptionPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): TranscriptionPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new TranscriptionPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): TranscriptionContext
    {
        return new TranscriptionContext($this->version, $this->solution['accountSid'], $this->solution['recordingSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.TranscriptionList]';
    }
}