<?php

namespace Twilio\Jwt;

use InvalidArgumentException;
use Twilio\Jwt\Client\ScopeURI;
use function array_merge;
use function http_build_query;
use function implode;
use function preg_match;
use function time;

class ClientToken
{
    public $accountSid;
    public $authToken;
    public $scopes;
    public $clientName;
    private $customClaims;

    public function __construct(string $accountSid, string $authToken)
    {
        $this->accountSid = $accountSid;
        $this->authToken = $authToken;
        $this->scopes = [];
        $this->clientName = false;
        $this->customClaims = [];
    }

    public function allowClientIncoming(string $clientName): void
    {
        if (preg_match('/\W/', $clientName)) {
            throw new InvalidArgumentException('Only alphanumeric characters allowed in client name.');
        }
        if ($clientName === '') {
            throw new InvalidArgumentException('Client name must not be a zero length string.');
        }
        $this->clientName = $clientName;
        $this->allow('client', 'incoming', ['clientName' => $clientName]);
    }

    public function allowClientOutgoing(string $appSid, array $appParams = []): void
    {
        $this->allow('client', 'outgoing', ['appSid' => $appSid, 'appParams' => http_build_query($appParams, '', '&')]);
    }

    public function allowEventStream(array $filters = []): void
    {
        $this->allow('stream', 'subscribe', ['path' => '/2010-04-01/Events', 'params' => http_build_query($filters, '', '&'),]);
    }

    public function addClaim(string $name, string $value): void
    {
        $this->customClaims[$name] = $value;
    }

    public function generateToken(int $ttl = 3600): string
    {
        $payload = array_merge($this->customClaims, ['scope' => [], 'iss' => $this->accountSid, 'exp' => time() + $ttl,]);
        $scopeStrings = [];
        foreach ($this->scopes as $scope) {
            if ($scope->privilege === 'outgoing' && $this->clientName) {
                $scope->params['clientName'] = $this->clientName;
            }
            $scopeStrings[] = $scope->toString();
        }
        $payload['scope'] = implode(' ', $scopeStrings);
        return JWT::encode($payload, $this->authToken, 'HS256');
    }

    protected function allow(string $service, string $privilege, array $params): void
    {
        $this->scopes[] = new ScopeURI($service, $privilege, $params);
    }
}