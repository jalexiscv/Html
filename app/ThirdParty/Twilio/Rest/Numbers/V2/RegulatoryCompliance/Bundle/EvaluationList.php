<?php

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance\Bundle;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class EvaluationList extends ListResource
{
    public function __construct(Version $version, string $bundleSid)
    {
        parent::__construct($version);
        $this->solution = ['bundleSid' => $bundleSid,];
        $this->uri = '/RegulatoryCompliance/Bundles/' . rawurlencode($bundleSid) . '/Evaluations';
    }

    public function create(): EvaluationInstance
    {
        $payload = $this->version->create('POST', $this->uri);
        return new EvaluationInstance($this->version, $payload, $this->solution['bundleSid']);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): EvaluationPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new EvaluationPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): EvaluationPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new EvaluationPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): EvaluationContext
    {
        return new EvaluationContext($this->version, $this->solution['bundleSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Numbers.V2.EvaluationList]';
    }
}