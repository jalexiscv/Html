<?php

namespace Higgs\HTTP;

use Higgs\HTTP\Exceptions\HTTPException;

trait MessageTrait
{
    protected $headers = [];
    protected $headerMap = [];

    public function setBody($data): self
    {
        $this->body = $data;
        return $this;
    }

    public function appendBody($data): self
    {
        $this->body .= (string)$data;
        return $this;
    }

    public function headers(): array
    {
        if (empty($this->headers)) {
            $this->populateHeaders();
        }
        return $this->headers;
    }

    public function populateHeaders(): void
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? getenv('CONTENT_TYPE');
        if (!empty($contentType)) {
            $this->setHeader('Content-Type', $contentType);
        }
        unset($contentType);
        foreach (array_keys($_SERVER) as $key) {
            if (sscanf($key, 'HTTP_%s', $header) === 1) {
                $header = str_replace('_', ' ', strtolower($header));
                $header = str_replace(' ', '-', ucwords($header));
                $this->setHeader($header, $_SERVER[$key]);
                $this->headerMap[strtolower($header)] = $header;
            }
        }
    }

    public function setHeader(string $name, $value): self
    {
        $origName = $this->getHeaderName($name);
        if (isset($this->headers[$origName]) && is_array($this->headers[$origName]->getValue())) {
            if (!is_array($value)) {
                $value = [$value];
            }
            foreach ($value as $v) {
                $this->appendHeader($origName, $v);
            }
        } else {
            $this->headers[$origName] = new Header($origName, $value);
            $this->headerMap[strtolower($origName)] = $origName;
        }
        return $this;
    }

    protected function getHeaderName(string $name): string
    {
        return $this->headerMap[strtolower($name)] ?? $name;
    }

    public function appendHeader(string $name, ?string $value): self
    {
        $origName = $this->getHeaderName($name);
        array_key_exists($origName, $this->headers) ? $this->headers[$origName]->appendValue($value) : $this->setHeader($name, $value);
        return $this;
    }

    public function header($name)
    {
        $origName = $this->getHeaderName($name);
        return $this->headers[$origName] ?? null;
    }

    public function removeHeader(string $name): self
    {
        $origName = $this->getHeaderName($name);
        unset($this->headers[$origName], $this->headerMap[strtolower($name)]);
        return $this;
    }

    public function prependHeader(string $name, string $value): self
    {
        $origName = $this->getHeaderName($name);
        $this->headers[$origName]->prependValue($value);
        return $this;
    }

    public function setProtocolVersion(string $version): self
    {
        if (!is_numeric($version)) {
            $version = substr($version, strpos($version, '/') + 1);
        }
        $version = number_format((float)$version, 1);
        if (!in_array($version, $this->validProtocolVersions, true)) {
            throw HTTPException::forInvalidHTTPProtocol(implode(', ', $this->validProtocolVersions));
        }
        $this->protocolVersion = $version;
        return $this;
    }
}