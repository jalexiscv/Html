<?php

namespace Higgs\HTTP;

use Higgs\Exceptions\DownloadException;
use Higgs\Files\File;
use Config\Mimes;

class DownloadResponse extends Response
{
    protected $reason = 'OK';
    protected $statusCode = 200;
    private string $filename;
    private ?File $file = null;
    private bool $setMime;
    private ?string $binary = null;
    private string $charset = 'UTF-8';

    public function __construct(string $filename, bool $setMime)
    {
        parent::__construct(config('App'));
        $this->filename = $filename;
        $this->setMime = $setMime;
        $this->removeHeader('Content-Type');
    }

    public function setBinary(string $binary)
    {
        if ($this->file !== null) {
            throw DownloadException::forCannotSetBinary();
        }
        $this->binary = $binary;
    }

    public function setFilePath(string $filepath)
    {
        if ($this->binary !== null) {
            throw DownloadException::forCannotSetFilePath($filepath);
        }
        $this->file = new File($filepath, true);
    }

    public function setFileName(string $filename)
    {
        $this->filename = $filename;
        return $this;
    }

    public function setStatusCode(int $code, string $reason = '')
    {
        throw DownloadException::forCannotSetStatusCode($code, $reason);
    }

    public function setCache(array $options = [])
    {
        throw DownloadException::forCannotSetCache();
    }

    public function send()
    {
        $this->buildHeaders();
        $this->sendHeaders();
        $this->sendBody();
        return $this;
    }

    public function buildHeaders()
    {
        if (!$this->hasHeader('Content-Type')) {
            $this->setContentTypeByMimeType();
        }
        $this->setHeader('Content-Disposition', $this->getContentDisposition());
        $this->setHeader('Expires-Disposition', '0');
        $this->setHeader('Content-Transfer-Encoding', 'binary');
        $this->setHeader('Content-Length', (string)$this->getContentLength());
        $this->noCache();
    }

    private function setContentTypeByMimeType()
    {
        $mime = null;
        $charset = '';
        if ($this->setMime === true && ($lastDotPosition = strrpos($this->filename, '.')) !== false) {
            $mime = Mimes::guessTypeFromExtension(substr($this->filename, $lastDotPosition + 1));
            $charset = $this->charset;
        }
        if (!is_string($mime)) {
            $mime = 'application/octet-stream';
            $charset = '';
        }
        $this->setContentType($mime, $charset);
    }

    public function setContentType(string $mime, string $charset = 'UTF-8')
    {
        parent::setContentType($mime, $charset);
        if ($charset !== '') {
            $this->charset = $charset;
        }
        return $this;
    }

    private function getContentDisposition(): string
    {
        $downloadFilename = $this->getDownloadFileName();
        $utf8Filename = $downloadFilename;
        if (strtoupper($this->charset) !== 'UTF-8') {
            $utf8Filename = mb_convert_encoding($downloadFilename, 'UTF-8', $this->charset);
        }
        $result = sprintf('attachment; filename="%s"', $downloadFilename);
        if ($utf8Filename) {
            $result .= '; filename*=UTF-8\'\'' . rawurlencode($utf8Filename);
        }
        return $result;
    }

    private function getDownloadFileName(): string
    {
        $filename = $this->filename;
        $x = explode('.', $this->filename);
        $extension = end($x);
        if (count($x) !== 1 && isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Android\s(1|2\.[01])/', $_SERVER['HTTP_USER_AGENT'])) {
            $x[count($x) - 1] = strtoupper($extension);
            $filename = implode('.', $x);
        }
        return $filename;
    }

    public function getContentLength(): int
    {
        if (is_string($this->binary)) {
            return strlen($this->binary);
        }
        if ($this->file instanceof File) {
            return $this->file->getSize();
        }
        return 0;
    }

    public function noCache(): self
    {
        $this->removeHeader('Cache-control');
        $this->setHeader('Cache-control', ['private', 'no-transform', 'no-store', 'must-revalidate']);
        return $this;
    }

    public function sendBody()
    {
        if ($this->binary !== null) {
            return $this->sendBodyByBinary();
        }
        if ($this->file !== null) {
            return $this->sendBodyByFilePath();
        }
        throw DownloadException::forNotFoundDownloadSource();
    }

    private function sendBodyByBinary()
    {
        echo $this->binary;
        return $this;
    }

    private function sendBodyByFilePath()
    {
        $splFileObject = $this->file->openFile('rb');
        while (!$splFileObject->eof() && ($data = $splFileObject->fread(1_048_576)) !== false) {
            echo $data;
            unset($data);
        }
        return $this;
    }
}