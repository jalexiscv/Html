<?php

namespace Higgs\Honeypot;

use Higgs\Honeypot\Exceptions\HoneypotException;
use Higgs\HTTP\IncomingRequest;
use Higgs\HTTP\RequestInterface;
use Higgs\HTTP\ResponseInterface;
use Config\Honeypot as HoneypotConfig;

class Honeypot
{
    protected $config;

    public function __construct(HoneypotConfig $config)
    {
        $this->config = $config;
        if (!$this->config->hidden) {
            throw HoneypotException::forNoHiddenValue();
        }
        if (empty($this->config->container) || strpos($this->config->container, '{template}') === false) {
            $this->config->container = '<div style="display:none">{template}</div>';
        }
        $this->config->containerId ??= 'hpc';
        if ($this->config->template === '') {
            throw HoneypotException::forNoTemplate();
        }
        if ($this->config->name === '') {
            throw HoneypotException::forNoNameField();
        }
    }

    public function hasContent(RequestInterface $request)
    {
        assert($request instanceof IncomingRequest);
        return !empty($request->getPost($this->config->name));
    }

    public function attachHoneypot(ResponseInterface $response)
    {
        if ($response->getCSP()->enabled()) {
            $this->config->container = str_ireplace('>{template}', ' id="' . $this->config->containerId . '">{template}', $this->config->container);
        }
        $prepField = $this->prepareTemplate($this->config->template);
        $body = $response->getBody();
        $body = str_ireplace('</form>', $prepField . '</form>', $body);
        if ($response->getCSP()->enabled()) {
            $style = '<style ' . csp_style_nonce() . '>#' . $this->config->containerId . ' { display:none }</style>';
            $body = str_ireplace('</head>', $style . '</head>', $body);
        }
        $response->setBody($body);
    }

    protected function prepareTemplate(string $template): string
    {
        $template = str_ireplace('{label}', $this->config->label, $template);
        $template = str_ireplace('{name}', $this->config->name, $template);
        if ($this->config->hidden) {
            $template = str_ireplace('{template}', $template, $this->config->container);
        }
        return $template;
    }
}