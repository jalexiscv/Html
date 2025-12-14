<?php

namespace Higgs\HTTP;

use Config\ContentSecurityPolicy as ContentSecurityPolicyConfig;

class ContentSecurityPolicy
{
    protected $baseURI = [];
    protected $childSrc = [];
    protected $connectSrc = [];
    protected $defaultSrc = [];
    protected $fontSrc = [];
    protected $formAction = [];
    protected $frameAncestors = [];
    protected $frameSrc = [];
    protected $imageSrc = [];
    protected $mediaSrc = [];
    protected $objectSrc = [];
    protected $pluginTypes = [];
    protected $reportURI;
    protected $sandbox = [];
    protected $scriptSrc = [];
    protected $styleSrc = [];
    protected $manifestSrc = [];
    protected $upgradeInsecureRequests = false;
    protected $reportOnly = false;
    protected $validSources = ['self', 'none', 'unsafe-inline', 'unsafe-eval',];
    protected $nonces = [];
    protected $styleNonce;
    protected $scriptNonce;
    protected $styleNonceTag = '{csp-style-nonce}';
    protected $scriptNonceTag = '{csp-script-nonce}';
    protected $autoNonce = true;
    protected $tempHeaders = [];
    protected $reportOnlyHeaders = [];
    protected $CSPEnabled = false;

    public function __construct(ContentSecurityPolicyConfig $config)
    {
        $appConfig = config('App');
        $this->CSPEnabled = $appConfig->CSPEnabled;
        foreach (get_object_vars($config) as $setting => $value) {
            if (property_exists($this, $setting)) {
                $this->{$setting} = $value;
            }
        }
        if (!is_array($this->styleSrc)) {
            $this->styleSrc = [$this->styleSrc];
        }
        if (!is_array($this->scriptSrc)) {
            $this->scriptSrc = [$this->scriptSrc];
        }
    }

    public function enabled(): bool
    {
        return $this->CSPEnabled;
    }

    public function finalize(ResponseInterface $response)
    {
        if ($this->autoNonce) {
            $this->generateNonces($response);
        }
        $this->buildHeaders($response);
    }

    protected function generateNonces(ResponseInterface $response)
    {
        $body = $response->getBody();
        if (empty($body)) {
            return;
        }
        $pattern = '/(' . preg_quote($this->styleNonceTag, '/') . '|' . preg_quote($this->scriptNonceTag, '/') . ')/';
        $body = preg_replace_callback($pattern, function ($match) {
            $nonce = $match[0] === $this->styleNonceTag ? $this->getStyleNonce() : $this->getScriptNonce();
            return "nonce=\"{$nonce}\"";
        }, $body);
        $response->setBody($body);
    }

    public function getStyleNonce(): string
    {
        if ($this->styleNonce === null) {
            $this->styleNonce = bin2hex(random_bytes(12));
            $this->styleSrc[] = 'nonce-' . $this->styleNonce;
        }
        return $this->styleNonce;
    }

    public function getScriptNonce(): string
    {
        if ($this->scriptNonce === null) {
            $this->scriptNonce = bin2hex(random_bytes(12));
            $this->scriptSrc[] = 'nonce-' . $this->scriptNonce;
        }
        return $this->scriptNonce;
    }

    protected function buildHeaders(ResponseInterface $response)
    {
        $response->setHeader('Content-Security-Policy', []);
        $response->setHeader('Content-Security-Policy-Report-Only', []);
        $directives = ['base-uri' => 'baseURI', 'child-src' => 'childSrc', 'connect-src' => 'connectSrc', 'default-src' => 'defaultSrc', 'font-src' => 'fontSrc', 'form-action' => 'formAction', 'frame-ancestors' => 'frameAncestors', 'frame-src' => 'frameSrc', 'img-src' => 'imageSrc', 'media-src' => 'mediaSrc', 'object-src' => 'objectSrc', 'plugin-types' => 'pluginTypes', 'script-src' => 'scriptSrc', 'style-src' => 'styleSrc', 'manifest-src' => 'manifestSrc', 'sandbox' => 'sandbox', 'report-uri' => 'reportURI',];
        if (empty($this->baseURI)) {
            $this->baseURI = 'self';
        }
        if (empty($this->defaultSrc)) {
            $this->defaultSrc = 'self';
        }
        foreach ($directives as $name => $property) {
            if (!empty($this->{$property})) {
                $this->addToHeader($name, $this->{$property});
            }
        }
        if (!empty($this->tempHeaders)) {
            $header = '';
            foreach ($this->tempHeaders as $name => $value) {
                $header .= " {$name} {$value};";
            }
            if ($this->upgradeInsecureRequests) {
                $header .= ' upgrade-insecure-requests;';
            }
            $response->appendHeader('Content-Security-Policy', $header);
        }
        if (!empty($this->reportOnlyHeaders)) {
            $header = '';
            foreach ($this->reportOnlyHeaders as $name => $value) {
                $header .= " {$name} {$value};";
            }
            $response->appendHeader('Content-Security-Policy-Report-Only', $header);
        }
        $this->tempHeaders = [];
        $this->reportOnlyHeaders = [];
    }

    protected function addToHeader(string $name, $values = null)
    {
        if (is_string($values)) {
            $values = [$values => $this->reportOnly];
        }
        $sources = [];
        $reportSources = [];
        foreach ($values as $value => $reportOnly) {
            if (is_numeric($value) && is_string($reportOnly) && !empty($reportOnly)) {
                $value = $reportOnly;
                $reportOnly = $this->reportOnly;
            }
            if (strpos($value, 'nonce-') === 0) {
                $value = "'{$value}'";
            }
            if ($reportOnly === true) {
                $reportSources[] = in_array($value, $this->validSources, true) ? "'{$value}'" : $value;
            } else {
                $sources[] = in_array($value, $this->validSources, true) ? "'{$value}'" : $value;
            }
        }
        if (!empty($sources)) {
            $this->tempHeaders[$name] = implode(' ', $sources);
        }
        if (!empty($reportSources)) {
            $this->reportOnlyHeaders[$name] = implode(' ', $reportSources);
        }
    }

    public function reportOnly(bool $value = true)
    {
        $this->reportOnly = $value;
        return $this;
    }

    public function addBaseURI($uri, ?bool $explicitReporting = null)
    {
        $this->addOption($uri, 'baseURI', $explicitReporting ?? $this->reportOnly);
        return $this;
    }

    protected function addOption($options, string $target, ?bool $explicitReporting = null)
    {
        if (is_string($this->{$target})) {
            $this->{$target} = [$this->{$target}];
        }
        if (is_array($options)) {
            foreach ($options as $opt) {
                $this->{$target}[$opt] = $explicitReporting ?? $this->reportOnly;
            }
        } else {
            $this->{$target}[$options] = $explicitReporting ?? $this->reportOnly;
        }
    }

    public function addChildSrc($uri, ?bool $explicitReporting = null)
    {
        $this->addOption($uri, 'childSrc', $explicitReporting ?? $this->reportOnly);
        return $this;
    }

    public function addConnectSrc($uri, ?bool $explicitReporting = null)
    {
        $this->addOption($uri, 'connectSrc', $explicitReporting ?? $this->reportOnly);
        return $this;
    }

    public function setDefaultSrc($uri, ?bool $explicitReporting = null)
    {
        $this->defaultSrc = [(string)$uri => $explicitReporting ?? $this->reportOnly];
        return $this;
    }

    public function addFontSrc($uri, ?bool $explicitReporting = null)
    {
        $this->addOption($uri, 'fontSrc', $explicitReporting ?? $this->reportOnly);
        return $this;
    }

    public function addFormAction($uri, ?bool $explicitReporting = null)
    {
        $this->addOption($uri, 'formAction', $explicitReporting ?? $this->reportOnly);
        return $this;
    }

    public function addFrameAncestor($uri, ?bool $explicitReporting = null)
    {
        $this->addOption($uri, 'frameAncestors', $explicitReporting ?? $this->reportOnly);
        return $this;
    }

    public function addFrameSrc($uri, ?bool $explicitReporting = null)
    {
        $this->addOption($uri, 'frameSrc', $explicitReporting ?? $this->reportOnly);
        return $this;
    }

    public function addImageSrc($uri, ?bool $explicitReporting = null)
    {
        $this->addOption($uri, 'imageSrc', $explicitReporting ?? $this->reportOnly);
        return $this;
    }

    public function addMediaSrc($uri, ?bool $explicitReporting = null)
    {
        $this->addOption($uri, 'mediaSrc', $explicitReporting ?? $this->reportOnly);
        return $this;
    }

    public function addManifestSrc($uri, ?bool $explicitReporting = null)
    {
        $this->addOption($uri, 'manifestSrc', $explicitReporting ?? $this->reportOnly);
        return $this;
    }

    public function addObjectSrc($uri, ?bool $explicitReporting = null)
    {
        $this->addOption($uri, 'objectSrc', $explicitReporting ?? $this->reportOnly);
        return $this;
    }

    public function addPluginType($mime, ?bool $explicitReporting = null)
    {
        $this->addOption($mime, 'pluginTypes', $explicitReporting ?? $this->reportOnly);
        return $this;
    }

    public function setReportURI(string $uri)
    {
        $this->reportURI = $uri;
        return $this;
    }

    public function addSandbox($flags, ?bool $explicitReporting = null)
    {
        $this->addOption($flags, 'sandbox', $explicitReporting ?? $this->reportOnly);
        return $this;
    }

    public function addScriptSrc($uri, ?bool $explicitReporting = null)
    {
        $this->addOption($uri, 'scriptSrc', $explicitReporting ?? $this->reportOnly);
        return $this;
    }

    public function addStyleSrc($uri, ?bool $explicitReporting = null)
    {
        $this->addOption($uri, 'styleSrc', $explicitReporting ?? $this->reportOnly);
        return $this;
    }

    public function upgradeInsecureRequests(bool $value = true)
    {
        $this->upgradeInsecureRequests = $value;
        return $this;
    }
}