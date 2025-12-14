<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class MessageOptions
{
    public static function create(string $from = Values::NONE, string $messagingServiceSid = Values::NONE, string $body = Values::NONE, array $mediaUrl = Values::ARRAY_NONE, string $statusCallback = Values::NONE, string $applicationSid = Values::NONE, string $maxPrice = Values::NONE, bool $provideFeedback = Values::NONE, int $attempt = Values::NONE, int $validityPeriod = Values::NONE, bool $forceDelivery = Values::NONE, string $contentRetention = Values::NONE, string $addressRetention = Values::NONE, bool $smartEncoded = Values::NONE, array $persistentAction = Values::ARRAY_NONE): CreateMessageOptions
    {
        return new CreateMessageOptions($from, $messagingServiceSid, $body, $mediaUrl, $statusCallback, $applicationSid, $maxPrice, $provideFeedback, $attempt, $validityPeriod, $forceDelivery, $contentRetention, $addressRetention, $smartEncoded, $persistentAction);
    }

    public static function read(string $to = Values::NONE, string $from = Values::NONE, string $dateSentBefore = Values::NONE, string $dateSent = Values::NONE, string $dateSentAfter = Values::NONE): ReadMessageOptions
    {
        return new ReadMessageOptions($to, $from, $dateSentBefore, $dateSent, $dateSentAfter);
    }
}

class CreateMessageOptions extends Options
{
    public function __construct(string $from = Values::NONE, string $messagingServiceSid = Values::NONE, string $body = Values::NONE, array $mediaUrl = Values::ARRAY_NONE, string $statusCallback = Values::NONE, string $applicationSid = Values::NONE, string $maxPrice = Values::NONE, bool $provideFeedback = Values::NONE, int $attempt = Values::NONE, int $validityPeriod = Values::NONE, bool $forceDelivery = Values::NONE, string $contentRetention = Values::NONE, string $addressRetention = Values::NONE, bool $smartEncoded = Values::NONE, array $persistentAction = Values::ARRAY_NONE)
    {
        $this->options['from'] = $from;
        $this->options['messagingServiceSid'] = $messagingServiceSid;
        $this->options['body'] = $body;
        $this->options['mediaUrl'] = $mediaUrl;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['applicationSid'] = $applicationSid;
        $this->options['maxPrice'] = $maxPrice;
        $this->options['provideFeedback'] = $provideFeedback;
        $this->options['attempt'] = $attempt;
        $this->options['validityPeriod'] = $validityPeriod;
        $this->options['forceDelivery'] = $forceDelivery;
        $this->options['contentRetention'] = $contentRetention;
        $this->options['addressRetention'] = $addressRetention;
        $this->options['smartEncoded'] = $smartEncoded;
        $this->options['persistentAction'] = $persistentAction;
    }

    public function setFrom(string $from): self
    {
        $this->options['from'] = $from;
        return $this;
    }

    public function setMessagingServiceSid(string $messagingServiceSid): self
    {
        $this->options['messagingServiceSid'] = $messagingServiceSid;
        return $this;
    }

    public function setBody(string $body): self
    {
        $this->options['body'] = $body;
        return $this;
    }

    public function setMediaUrl(array $mediaUrl): self
    {
        $this->options['mediaUrl'] = $mediaUrl;
        return $this;
    }

    public function setStatusCallback(string $statusCallback): self
    {
        $this->options['statusCallback'] = $statusCallback;
        return $this;
    }

    public function setApplicationSid(string $applicationSid): self
    {
        $this->options['applicationSid'] = $applicationSid;
        return $this;
    }

    public function setMaxPrice(string $maxPrice): self
    {
        $this->options['maxPrice'] = $maxPrice;
        return $this;
    }

    public function setProvideFeedback(bool $provideFeedback): self
    {
        $this->options['provideFeedback'] = $provideFeedback;
        return $this;
    }

    public function setAttempt(int $attempt): self
    {
        $this->options['attempt'] = $attempt;
        return $this;
    }

    public function setValidityPeriod(int $validityPeriod): self
    {
        $this->options['validityPeriod'] = $validityPeriod;
        return $this;
    }

    public function setForceDelivery(bool $forceDelivery): self
    {
        $this->options['forceDelivery'] = $forceDelivery;
        return $this;
    }

    public function setContentRetention(string $contentRetention): self
    {
        $this->options['contentRetention'] = $contentRetention;
        return $this;
    }

    public function setAddressRetention(string $addressRetention): self
    {
        $this->options['addressRetention'] = $addressRetention;
        return $this;
    }

    public function setSmartEncoded(bool $smartEncoded): self
    {
        $this->options['smartEncoded'] = $smartEncoded;
        return $this;
    }

    public function setPersistentAction(array $persistentAction): self
    {
        $this->options['persistentAction'] = $persistentAction;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.CreateMessageOptions ' . $options . ']';
    }
}

class ReadMessageOptions extends Options
{
    public function __construct(string $to = Values::NONE, string $from = Values::NONE, string $dateSentBefore = Values::NONE, string $dateSent = Values::NONE, string $dateSentAfter = Values::NONE)
    {
        $this->options['to'] = $to;
        $this->options['from'] = $from;
        $this->options['dateSentBefore'] = $dateSentBefore;
        $this->options['dateSent'] = $dateSent;
        $this->options['dateSentAfter'] = $dateSentAfter;
    }

    public function setTo(string $to): self
    {
        $this->options['to'] = $to;
        return $this;
    }

    public function setFrom(string $from): self
    {
        $this->options['from'] = $from;
        return $this;
    }

    public function setDateSentBefore(string $dateSentBefore): self
    {
        $this->options['dateSentBefore'] = $dateSentBefore;
        return $this;
    }

    public function setDateSent(string $dateSent): self
    {
        $this->options['dateSent'] = $dateSent;
        return $this;
    }

    public function setDateSentAfter(string $dateSentAfter): self
    {
        $this->options['dateSentAfter'] = $dateSentAfter;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.ReadMessageOptions ' . $options . ']';
    }
}