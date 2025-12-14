<?php

namespace Facebook\Url;
class FacebookUrlDetectionHandler implements UrlDetectionInterface
{
    public function getCurrentUrl()
    {
        return $this->getHttpScheme() . '://' . $this->getHostName() . $this->getServerVar('REQUEST_URI');
    }

    protected function getHttpScheme()
    {
        return $this->isBehindSsl() ? 'https' : 'http';
    }

    protected function isBehindSsl()
    {
        $protocol = $this->getHeader('X_FORWARDED_PROTO');
        if ($protocol) {
            return $this->protocolWithActiveSsl($protocol);
        }
        $protocol = $this->getServerVar('HTTPS');
        if ($protocol) {
            return $this->protocolWithActiveSsl($protocol);
        }
        return (string)$this->getServerVar('SERVER_PORT') === '443';
    }

    protected function protocolWithActiveSsl($protocol)
    {
        $protocol = strtolower((string)$protocol);
        return in_array($protocol, ['on', '1', 'https', 'ssl'], true);
    }

    protected function getHostName()
    {
        $header = $this->getHeader('X_FORWARDED_HOST');
        if ($header && $this->isValidForwardedHost($header)) {
            $elements = explode(',', $header);
            $host = $elements[count($elements) - 1];
        } elseif (!$host = $this->getHeader('HOST')) {
            if (!$host = $this->getServerVar('SERVER_NAME')) {
                $host = $this->getServerVar('SERVER_ADDR');
            }
        }
        $host = strtolower(preg_replace('/:\d+$/', '', trim($host)));
        $scheme = $this->getHttpScheme();
        $port = $this->getCurrentPort();
        $appendPort = ':' . $port;
        if (($scheme == 'http' && $port == '80') || ($scheme == 'https' && $port == '443')) {
            $appendPort = '';
        }
        return $host . $appendPort;
    }

    protected function getCurrentPort()
    {
        $port = $this->getHeader('X_FORWARDED_PORT');
        if ($port) {
            return (string)$port;
        }
        $protocol = (string)$this->getHeader('X_FORWARDED_PROTO');
        if ($protocol === 'https') {
            return '443';
        }
        return (string)$this->getServerVar('SERVER_PORT');
    }

    protected function getServerVar($key)
    {
        return isset($_SERVER[$key]) ? $_SERVER[$key] : '';
    }

    protected function getHeader($key)
    {
        return $this->getServerVar('HTTP_' . $key);
    }

    protected function isValidForwardedHost($header)
    {
        $elements = explode(',', $header);
        $host = $elements[count($elements) - 1];
        return preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $host) && 0 < strlen($host) && strlen($host) < 254 && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $host);
    }
}