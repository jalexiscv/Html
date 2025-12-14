<?php

namespace Twilio\Rest\Wireless\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class CommandOptions
{
    public static function read(string $sim = Values::NONE, string $status = Values::NONE, string $direction = Values::NONE, string $transport = Values::NONE): ReadCommandOptions
    {
        return new ReadCommandOptions($sim, $status, $direction, $transport);
    }

    public static function create(string $sim = Values::NONE, string $callbackMethod = Values::NONE, string $callbackUrl = Values::NONE, string $commandMode = Values::NONE, string $includeSid = Values::NONE, bool $deliveryReceiptRequested = Values::NONE): CreateCommandOptions
    {
        return new CreateCommandOptions($sim, $callbackMethod, $callbackUrl, $commandMode, $includeSid, $deliveryReceiptRequested);
    }
}

class ReadCommandOptions extends Options
{
    public function __construct(string $sim = Values::NONE, string $status = Values::NONE, string $direction = Values::NONE, string $transport = Values::NONE)
    {
        $this->options['sim'] = $sim;
        $this->options['status'] = $status;
        $this->options['direction'] = $direction;
        $this->options['transport'] = $transport;
    }

    public function setSim(string $sim): self
    {
        $this->options['sim'] = $sim;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setDirection(string $direction): self
    {
        $this->options['direction'] = $direction;
        return $this;
    }

    public function setTransport(string $transport): self
    {
        $this->options['transport'] = $transport;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Wireless.V1.ReadCommandOptions ' . $options . ']';
    }
}

class CreateCommandOptions extends Options
{
    public function __construct(string $sim = Values::NONE, string $callbackMethod = Values::NONE, string $callbackUrl = Values::NONE, string $commandMode = Values::NONE, string $includeSid = Values::NONE, bool $deliveryReceiptRequested = Values::NONE)
    {
        $this->options['sim'] = $sim;
        $this->options['callbackMethod'] = $callbackMethod;
        $this->options['callbackUrl'] = $callbackUrl;
        $this->options['commandMode'] = $commandMode;
        $this->options['includeSid'] = $includeSid;
        $this->options['deliveryReceiptRequested'] = $deliveryReceiptRequested;
    }

    public function setSim(string $sim): self
    {
        $this->options['sim'] = $sim;
        return $this;
    }

    public function setCallbackMethod(string $callbackMethod): self
    {
        $this->options['callbackMethod'] = $callbackMethod;
        return $this;
    }

    public function setCallbackUrl(string $callbackUrl): self
    {
        $this->options['callbackUrl'] = $callbackUrl;
        return $this;
    }

    public function setCommandMode(string $commandMode): self
    {
        $this->options['commandMode'] = $commandMode;
        return $this;
    }

    public function setIncludeSid(string $includeSid): self
    {
        $this->options['includeSid'] = $includeSid;
        return $this;
    }

    public function setDeliveryReceiptRequested(bool $deliveryReceiptRequested): self
    {
        $this->options['deliveryReceiptRequested'] = $deliveryReceiptRequested;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Wireless.V1.CreateCommandOptions ' . $options . ']';
    }
}