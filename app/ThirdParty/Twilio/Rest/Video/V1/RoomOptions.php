<?php

namespace Twilio\Rest\Video\V1;

use DateTime;
use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class RoomOptions
{
    public static function create(bool $enableTurn = Values::NONE, string $type = Values::NONE, string $uniqueName = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, int $maxParticipants = Values::NONE, bool $recordParticipantsOnConnect = Values::NONE, array $videoCodecs = Values::ARRAY_NONE, string $mediaRegion = Values::NONE): CreateRoomOptions
    {
        return new CreateRoomOptions($enableTurn, $type, $uniqueName, $statusCallback, $statusCallbackMethod, $maxParticipants, $recordParticipantsOnConnect, $videoCodecs, $mediaRegion);
    }

    public static function read(string $status = Values::NONE, string $uniqueName = Values::NONE, DateTime $dateCreatedAfter = Values::NONE, DateTime $dateCreatedBefore = Values::NONE): ReadRoomOptions
    {
        return new ReadRoomOptions($status, $uniqueName, $dateCreatedAfter, $dateCreatedBefore);
    }
}

class CreateRoomOptions extends Options
{
    public function __construct(bool $enableTurn = Values::NONE, string $type = Values::NONE, string $uniqueName = Values::NONE, string $statusCallback = Values::NONE, string $statusCallbackMethod = Values::NONE, int $maxParticipants = Values::NONE, bool $recordParticipantsOnConnect = Values::NONE, array $videoCodecs = Values::ARRAY_NONE, string $mediaRegion = Values::NONE)
    {
        $this->options['enableTurn'] = $enableTurn;
        $this->options['type'] = $type;
        $this->options['uniqueName'] = $uniqueName;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        $this->options['maxParticipants'] = $maxParticipants;
        $this->options['recordParticipantsOnConnect'] = $recordParticipantsOnConnect;
        $this->options['videoCodecs'] = $videoCodecs;
        $this->options['mediaRegion'] = $mediaRegion;
    }

    public function setEnableTurn(bool $enableTurn): self
    {
        $this->options['enableTurn'] = $enableTurn;
        return $this;
    }

    public function setType(string $type): self
    {
        $this->options['type'] = $type;
        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setStatusCallback(string $statusCallback): self
    {
        $this->options['statusCallback'] = $statusCallback;
        return $this;
    }

    public function setStatusCallbackMethod(string $statusCallbackMethod): self
    {
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        return $this;
    }

    public function setMaxParticipants(int $maxParticipants): self
    {
        $this->options['maxParticipants'] = $maxParticipants;
        return $this;
    }

    public function setRecordParticipantsOnConnect(bool $recordParticipantsOnConnect): self
    {
        $this->options['recordParticipantsOnConnect'] = $recordParticipantsOnConnect;
        return $this;
    }

    public function setVideoCodecs(array $videoCodecs): self
    {
        $this->options['videoCodecs'] = $videoCodecs;
        return $this;
    }

    public function setMediaRegion(string $mediaRegion): self
    {
        $this->options['mediaRegion'] = $mediaRegion;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Video.V1.CreateRoomOptions ' . $options . ']';
    }
}

class ReadRoomOptions extends Options
{
    public function __construct(string $status = Values::NONE, string $uniqueName = Values::NONE, DateTime $dateCreatedAfter = Values::NONE, DateTime $dateCreatedBefore = Values::NONE)
    {
        $this->options['status'] = $status;
        $this->options['uniqueName'] = $uniqueName;
        $this->options['dateCreatedAfter'] = $dateCreatedAfter;
        $this->options['dateCreatedBefore'] = $dateCreatedBefore;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setDateCreatedAfter(DateTime $dateCreatedAfter): self
    {
        $this->options['dateCreatedAfter'] = $dateCreatedAfter;
        return $this;
    }

    public function setDateCreatedBefore(DateTime $dateCreatedBefore): self
    {
        $this->options['dateCreatedBefore'] = $dateCreatedBefore;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Video.V1.ReadRoomOptions ' . $options . ']';
    }
}