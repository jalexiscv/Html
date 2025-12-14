<?php

namespace Twilio\Rest\Preview\Sync\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class DocumentOptions
{
    public static function delete(string $ifMatch = Values::NONE): DeleteDocumentOptions
    {
        return new DeleteDocumentOptions($ifMatch);
    }

    public static function create(string $uniqueName = Values::NONE, array $data = Values::ARRAY_NONE): CreateDocumentOptions
    {
        return new CreateDocumentOptions($uniqueName, $data);
    }

    public static function update(string $ifMatch = Values::NONE): UpdateDocumentOptions
    {
        return new UpdateDocumentOptions($ifMatch);
    }
}

class DeleteDocumentOptions extends Options
{
    public function __construct(string $ifMatch = Values::NONE)
    {
        $this->options['ifMatch'] = $ifMatch;
    }

    public function setIfMatch(string $ifMatch): self
    {
        $this->options['ifMatch'] = $ifMatch;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Sync.DeleteDocumentOptions ' . $options . ']';
    }
}

class CreateDocumentOptions extends Options
{
    public function __construct(string $uniqueName = Values::NONE, array $data = Values::ARRAY_NONE)
    {
        $this->options['uniqueName'] = $uniqueName;
        $this->options['data'] = $data;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setData(array $data): self
    {
        $this->options['data'] = $data;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Sync.CreateDocumentOptions ' . $options . ']';
    }
}

class UpdateDocumentOptions extends Options
{
    public function __construct(string $ifMatch = Values::NONE)
    {
        $this->options['ifMatch'] = $ifMatch;
    }

    public function setIfMatch(string $ifMatch): self
    {
        $this->options['ifMatch'] = $ifMatch;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Sync.UpdateDocumentOptions ' . $options . ']';
    }
}