<?php

namespace Facebook\FileUpload;
class FacebookTransferChunk
{
    private $file;
    private $uploadSessionId;
    private $startOffset;
    private $endOffset;
    private $videoId;

    public function __construct(FacebookFile $file, $uploadSessionId, $videoId, $startOffset, $endOffset)
    {
        $this->file = $file;
        $this->uploadSessionId = $uploadSessionId;
        $this->videoId = $videoId;
        $this->startOffset = $startOffset;
        $this->endOffset = $endOffset;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getPartialFile()
    {
        $maxLength = $this->endOffset - $this->startOffset;
        return new FacebookFile($this->file->getFilePath(), $maxLength, $this->startOffset);
    }

    public function getUploadSessionId()
    {
        return $this->uploadSessionId;
    }

    public function isLastChunk()
    {
        return $this->startOffset === $this->endOffset;
    }

    public function getStartOffset()
    {
        return $this->startOffset;
    }

    public function getEndOffset()
    {
        return $this->endOffset;
    }

    public function getVideoId()
    {
        return $this->videoId;
    }
}