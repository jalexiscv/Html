<?php

namespace Twilio\Rest\Verify\V2\Service\Entity;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class ChallengeList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $identity)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'identity' => $identity,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Entities/' . rawurlencode($identity) . '/Challenges';
    }

    public function create(string $factorSid, array $options = []): ChallengeInstance
    {
        $options = new Values($options);
        $data = Values::of(['FactorSid' => $factorSid, 'ExpirationDate' => Serialize::iso8601DateTime($options['expirationDate']), 'Details.Message' => $options['detailsMessage'], 'Details.Fields' => Serialize::map($options['detailsFields'], function ($e) {
            return Serialize::jsonObject($e);
        }), 'HiddenDetails' => Serialize::jsonObject($options['hiddenDetails']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new ChallengeInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['identity']);
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): ChallengePage
    {
        $options = new Values($options);
        $params = Values::of(['FactorSid' => $options['factorSid'], 'Status' => $options['status'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new ChallengePage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): ChallengePage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new ChallengePage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): ChallengeContext
    {
        return new ChallengeContext($this->version, $this->solution['serviceSid'], $this->solution['identity'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Verify.V2.ChallengeList]';
    }
}