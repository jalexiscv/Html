<?php

namespace Twilio\Rest\Verify\V2\Service\Entity;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ChallengeOptions
{
    public static function create(DateTime $expirationDate = Values::NONE, string $detailsMessage = Values::NONE, array $detailsFields = Values::ARRAY_NONE, array $hiddenDetails = Values::ARRAY_NONE): CreateChallengeOptions
    {
        return new CreateChallengeOptions($expirationDate, $detailsMessage, $detailsFields, $hiddenDetails);
    }

    public static function read(string $factorSid = Values::NONE, string $status = Values::NONE): ReadChallengeOptions
    {
        return new ReadChallengeOptions($factorSid, $status);
    }

    public static function update(string $authPayload = Values::NONE): UpdateChallengeOptions
    {
        return new UpdateChallengeOptions($authPayload);
    }
}

class CreateChallengeOptions extends Options
{
    public function __construct(DateTime $expirationDate = Values::NONE, string $detailsMessage = Values::NONE, array $detailsFields = Values::ARRAY_NONE, array $hiddenDetails = Values::ARRAY_NONE)
    {
        $this->options['expirationDate'] = $expirationDate;
        $this->options['detailsMessage'] = $detailsMessage;
        $this->options['detailsFields'] = $detailsFields;
        $this->options['hiddenDetails'] = $hiddenDetails;
    }

    public function setExpirationDate(DateTime $expirationDate): self
    {
        $this->options['expirationDate'] = $expirationDate;
        return $this;
    }

    public function setDetailsMessage(string $detailsMessage): self
    {
        $this->options['detailsMessage'] = $detailsMessage;
        return $this;
    }

    public function setDetailsFields(array $detailsFields): self
    {
        $this->options['detailsFields'] = $detailsFields;
        return $this;
    }

    public function setHiddenDetails(array $hiddenDetails): self
    {
        $this->options['hiddenDetails'] = $hiddenDetails;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.CreateChallengeOptions ' . $options . ']';
    }
}

class ReadChallengeOptions extends Options
{
    public function __construct(string $factorSid = Values::NONE, string $status = Values::NONE)
    {
        $this->options['factorSid'] = $factorSid;
        $this->options['status'] = $status;
    }

    public function setFactorSid(string $factorSid): self
    {
        $this->options['factorSid'] = $factorSid;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.ReadChallengeOptions ' . $options . ']';
    }
}

class UpdateChallengeOptions extends Options
{
    public function __construct(string $authPayload = Values::NONE)
    {
        $this->options['authPayload'] = $authPayload;
    }

    public function setAuthPayload(string $authPayload): self
    {
        $this->options['authPayload'] = $authPayload;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Verify.V2.UpdateChallengeOptions ' . $options . ']';
    }
}