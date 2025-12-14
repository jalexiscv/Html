<?php

namespace Facebook\FileUpload;

use Facebook\Exceptions\FacebookSDKException;

class FacebookFile
{
    protected $path;
    protected $stream;
    private $maxLength;
    private $offset;

    public function __construct($filePath, $maxLength = -1, $offset = -1)
    {
        $this->path = $filePath;
        $this->maxLength = $maxLength;
        $this->offset = $offset;
        $this->open();
    }

    public function __destruct()
    {
        $this->close();
    }

    public function open()
    {
        if (!$this->isRemoteFile($this->path) && !is_readable($this->path)) {
            throw new FacebookSDKException('Failed to create FacebookFile entity. Unable to read resource: ' . $this->path . '.');
        }
        $this->stream = fopen($this->path, 'r');
        if (!$this->stream) {
            throw new FacebookSDKException('Failed to create FacebookFile entity. Unable to open resource: ' . $this->path . '.');
        }
    }

    public function close()
    {
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }
    }

    public function getContents()
    {
        return stream_get_contents($this->stream, $this->maxLength, $this->offset);
    }

    public function getFileName()
    {
        return basename($this->path);
    }

    public function getFilePath()
    {
        return $this->path;
    }

    public function getSize()
    {
        return filesize($this->path);
    }

    public function getMimetype()
    {
        return Mimetypes::getInstance()->fromFilename($this->path) ?: 'text/plain';
    }

    protected function isRemoteFile($pathToFile)
    {
        return preg_match('/^(https?|ftp):\/\/.*/', $pathToFile) === 1;
    }
}