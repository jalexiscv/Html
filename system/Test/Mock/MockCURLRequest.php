<?php

namespace Higgs\Test\Mock;

use Higgs\HTTP\CURLRequest;

class MockCURLRequest extends CURLRequest
{
    public $curl_options;
    protected $output = '';

    public function setOutput($output)
    {
        $this->output = $output;
        return $this;
    }

    public function getBaseURI()
    {
        return $this->baseURI;
    }

    public function getDelay()
    {
        return $this->delay;
    }

    protected function sendRequest(array $curlOptions = []): string
    {
        $this->curl_options = $curlOptions;
        return $this->output;
    }
}