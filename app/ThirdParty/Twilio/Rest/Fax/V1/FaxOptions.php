<?php

namespace Twilio\Rest\Fax\V1;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class FaxOptions
{
    public static function read(string $from = Values::NONE, string $to = Values::NONE, DateTime $dateCreatedOnOrBefore = Values::NONE, DateTime $dateCreatedAfter = Values::NONE): ReadFaxOptions
    {
        return new ReadFaxOptions($from, $to, $dateCreatedOnOrBefore, $dateCreatedAfter);
    }

    public static function create(string $quality = Values::NONE, string $statusCallback = Values::NONE, string $from = Values::NONE, string $sipAuthUsername = Values::NONE, string $sipAuthPassword = Values::NONE, bool $storeMedia = Values::NONE, int $ttl = Values::NONE): CreateFaxOptions
    {
        return new CreateFaxOptions($quality, $statusCallback, $from, $sipAuthUsername, $sipAuthPassword, $storeMedia, $ttl);
    }

    public static function update(string $status = Values::NONE): UpdateFaxOptions
    {
        return new UpdateFaxOptions($status);
    }
}

class ReadFaxOptions extends Options
{
    public function __construct(string $from = Values::NONE, string $to = Values::NONE, DateTime $dateCreatedOnOrBefore = Values::NONE, DateTime $dateCreatedAfter = Values::NONE)
    {
        $this->options['from'] = $from;
        $this->options['to'] = $to;
        $this->options['dateCreatedOnOrBefore'] = $dateCreatedOnOrBefore;
        $this->options['dateCreatedAfter'] = $dateCreatedAfter;
    }

    public function setFrom(string $from): self
    {
        $this->options['from'] = $from;
        return $this;
    }

    public function setTo(string $to): self
    {
        $this->options['to'] = $to;
        return $this;
    }

    public function setDateCreatedOnOrBefore(DateTime $dateCreatedOnOrBefore): self
    {
        $this->options['dateCreatedOnOrBefore'] = $dateCreatedOnOrBefore;
        return $this;
    }

    public function setDateCreatedAfter(DateTime $dateCreatedAfter): self
    {
        $this->options['dateCreatedAfter'] = $dateCreatedAfter;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Fax.V1.ReadFaxOptions ' . $options . ']';
    }
}

class CreateFaxOptions extends Options
{
    public function __construct(string $quality = Values::NONE, string $statusCallback = Values::NONE, string $from = Values::NONE, string $sipAuthUsername = Values::NONE, string $sipAuthPassword = Values::NONE, bool $storeMedia = Values::NONE, int $ttl = Values::NONE)
    {
        $this->options['quality'] = $quality;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['from'] = $from;
        $this->options['sipAuthUsername'] = $sipAuthUsername;
        $this->options['sipAuthPassword'] = $sipAuthPassword;
        $this->options['storeMedia'] = $storeMedia;
        $this->options['ttl'] = $ttl;
    }

    public function setQuality(string $quality): self
    {
        $this->options['quality'] = $quality;
        return $this;
    }

    public function setStatusCallback(string $statusCallback): self
    {
        $this->options['statusCallback'] = $statusCallback;
        return $this;
    }

    public function setFrom(string $from): self
    {
        $this->options['from'] = $from;
        return $this;
    }

    public function setSipAuthUsername(string $sipAuthUsername): self
    {
        $this->options['sipAuthUsername'] = $sipAuthUsername;
        return $this;
    }

    public function setSipAuthPassword(string $sipAuthPassword): self
    {
        $this->options['sipAuthPassword'] = $sipAuthPassword;
        return $this;
    }

    public function setStoreMedia(bool $storeMedia): self
    {
        $this->options['storeMedia'] = $storeMedia;
        return $this;
    }

    public function setTtl(int $ttl): self
    {
        $this->options['ttl'] = $ttl;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Fax.V1.CreateFaxOptions ' . $options . ']';
    }
}

class UpdateFaxOptions extends Options
{
    public function __construct(string $status = Values::NONE)
    {
        $this->options['status'] = $status;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Fax.V1.UpdateFaxOptions ' . $options . ']';
    }
}