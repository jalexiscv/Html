<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Api\V2010\Account\Call\FeedbackSummaryContext;
use Twilio\Rest\Api\V2010\Account\Call\FeedbackSummaryList;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function iterator_to_array;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class CallList extends ListResource
{
    protected $_feedbackSummaries = null;

    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Calls.json';
    }

    public function create(string $to, string $from, array $options = []): CallInstance
    {
        $options = new Values($options);
        $data = Values::of(['To' => $to, 'From' => $from, 'Url' => $options['url'], 'Twiml' => $options['twiml'], 'ApplicationSid' => $options['applicationSid'], 'Method' => $options['method'], 'FallbackUrl' => $options['fallbackUrl'], 'FallbackMethod' => $options['fallbackMethod'], 'StatusCallback' => $options['statusCallback'], 'StatusCallbackEvent' => Serialize::map($options['statusCallbackEvent'], function ($e) {
            return $e;
        }), 'StatusCallbackMethod' => $options['statusCallbackMethod'], 'SendDigits' => $options['sendDigits'], 'Timeout' => $options['timeout'], 'Record' => Serialize::booleanToString($options['record']), 'RecordingChannels' => $options['recordingChannels'], 'RecordingStatusCallback' => $options['recordingStatusCallback'], 'RecordingStatusCallbackMethod' => $options['recordingStatusCallbackMethod'], 'SipAuthUsername' => $options['sipAuthUsername'], 'SipAuthPassword' => $options['sipAuthPassword'], 'MachineDetection' => $options['machineDetection'], 'MachineDetectionTimeout' => $options['machineDetectionTimeout'], 'RecordingStatusCallbackEvent' => Serialize::map($options['recordingStatusCallbackEvent'], function ($e) {
            return $e;
        }), 'Trim' => $options['trim'], 'CallerId' => $options['callerId'], 'MachineDetectionSpeechThreshold' => $options['machineDetectionSpeechThreshold'], 'MachineDetectionSpeechEndThreshold' => $options['machineDetectionSpeechEndThreshold'], 'MachineDetectionSilenceTimeout' => $options['machineDetectionSilenceTimeout'], 'AsyncAmd' => $options['asyncAmd'], 'AsyncAmdStatusCallback' => $options['asyncAmdStatusCallback'], 'AsyncAmdStatusCallbackMethod' => $options['asyncAmdStatusCallbackMethod'], 'Byoc' => $options['byoc'], 'CallReason' => $options['callReason'], 'RecordingTrack' => $options['recordingTrack'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new CallInstance($this->version, $payload, $this->solution['accountSid']);
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): CallPage
    {
        $options = new Values($options);
        $params = Values::of(['To' => $options['to'], 'From' => $options['from'], 'ParentCallSid' => $options['parentCallSid'], 'Status' => $options['status'], 'StartTime<' => Serialize::iso8601DateTime($options['startTimeBefore']), 'StartTime' => Serialize::iso8601DateTime($options['startTime']), 'StartTime>' => Serialize::iso8601DateTime($options['startTimeAfter']), 'EndTime<' => Serialize::iso8601DateTime($options['endTimeBefore']), 'EndTime' => Serialize::iso8601DateTime($options['endTime']), 'EndTime>' => Serialize::iso8601DateTime($options['endTimeAfter']), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new CallPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): CallPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new CallPage($this->version, $response, $this->solution);
    }

    protected function getFeedbackSummaries(): FeedbackSummaryList
    {
        if (!$this->_feedbackSummaries) {
            $this->_feedbackSummaries = new FeedbackSummaryList($this->version, $this->solution['accountSid']);
        }
        return $this->_feedbackSummaries;
    }

    public function getContext(string $sid): CallContext
    {
        return new CallContext($this->version, $this->solution['accountSid'], $sid);
    }

    public function __get(string $name)
    {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown subresource ' . $name);
    }

    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        throw new TwilioException('Resource does not have a context');
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.CallList]';
    }
}