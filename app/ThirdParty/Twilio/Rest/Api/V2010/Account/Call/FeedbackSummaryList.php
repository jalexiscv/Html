<?php

namespace Twilio\Rest\Api\V2010\Account\Call;

use DateTime;
use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function rawurlencode;

class FeedbackSummaryList extends ListResource
{
    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Calls/FeedbackSummary.json';
    }

    public function create(DateTime $startDate, DateTime $endDate, array $options = []): FeedbackSummaryInstance
    {
        $options = new Values($options);
        $data = Values::of(['StartDate' => Serialize::iso8601Date($startDate), 'EndDate' => Serialize::iso8601Date($endDate), 'IncludeSubaccounts' => Serialize::booleanToString($options['includeSubaccounts']), 'StatusCallback' => $options['statusCallback'], 'StatusCallbackMethod' => $options['statusCallbackMethod'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new FeedbackSummaryInstance($this->version, $payload, $this->solution['accountSid']);
    }

    public function getContext(string $sid): FeedbackSummaryContext
    {
        return new FeedbackSummaryContext($this->version, $this->solution['accountSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.FeedbackSummaryList]';
    }
}