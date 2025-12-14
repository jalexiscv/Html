<?php

namespace Higgs\Filters;

use Higgs\HTTP\IncomingRequest;
use Higgs\HTTP\RequestInterface;
use Higgs\HTTP\ResponseInterface;
use Higgs\Security\Exceptions\SecurityException;

class InvalidChars implements FilterInterface
{
    protected $source;
    protected $controlCodeRegex = '/\A[\r\n\t[:^cntrl:]]*\z/u';

    public function before(RequestInterface $request, $arguments = null)
    {
        if (!$request instanceof IncomingRequest) {
            return;
        }
        $data = ['get' => $request->getGet(), 'post' => $request->getPost(), 'cookie' => $request->getCookie(), 'rawInput' => $request->getRawInput(),];
        foreach ($data as $source => $values) {
            $this->source = $source;
            $this->checkEncoding($values);
            $this->checkControl($values);
        }
    }

    protected function checkEncoding($value)
    {
        if (is_array($value)) {
            array_map([$this, 'checkEncoding'], $value);
            return $value;
        }
        if (mb_check_encoding($value, 'UTF-8')) {
            return $value;
        }
        throw SecurityException::forInvalidUTF8Chars($this->source, $value);
    }

    protected function checkControl($value)
    {
        if (is_array($value)) {
            array_map([$this, 'checkControl'], $value);
            return $value;
        }
        if (preg_match($this->controlCodeRegex, $value) === 1) {
            return $value;
        }
        throw SecurityException::forInvalidControlChars($this->source, $value);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}