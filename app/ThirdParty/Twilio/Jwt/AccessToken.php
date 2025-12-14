<?php

namespace Twilio\Jwt;

use Twilio\Jwt\Grants\Grant;
use function array_merge;
use function json_decode;
use function time;

class AccessToken
{
    private $signingKeySid;
    private $accountSid;
    private $secret;
    private $ttl;
    private $identity;
    private $nbf;
    private $region;
    private $grants;
    private $customClaims;

    public function __construct(string $accountSid, string $signingKeySid, string $secret, int $ttl = 3600, string $identity = null, string $region = null)
    {
        $this->signingKeySid = $signingKeySid;
        $this->accountSid = $accountSid;
        $this->secret = $secret;
        $this->ttl = $ttl;
        $this->region = $region;
        if ($identity !== null) {
            $this->identity = $identity;
        }
        $this->grants = [];
        $this->customClaims = [];
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }

    public function setIdentity(string $identity): self
    {
        $this->identity = $identity;
        return $this;
    }

    public function getNbf(): int
    {
        return $this->nbf;
    }

    public function setNbf(int $nbf): self
    {
        $this->nbf = $nbf;
        return $this;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;
        return $this;
    }

    public function addGrant(Grant $grant): self
    {
        $this->grants[] = $grant;
        return $this;
    }

    public function addClaim(string $name, string $value): void
    {
        $this->customClaims[$name] = $value;
    }

    public function __toString(): string
    {
        return $this->toJWT();
    }

    public function toJWT(string $algorithm = 'HS256'): string
    {
        $header = ['cty' => 'twilio-fpa;v=1', 'typ' => 'JWT'];
        if ($this->region) {
            $header['twr'] = $this->region;
        }
        $now = time();
        $grants = [];
        if ($this->identity) {
            $grants['identity'] = $this->identity;
        }
        foreach ($this->grants as $grant) {
            $payload = $grant->getPayload();
            if (empty($payload)) {
                $payload = json_decode('{}');
            }
            $grants[$grant->getGrantKey()] = $payload;
        }
        if (empty($grants)) {
            $grants = json_decode('{}');
        }
        $payload = array_merge($this->customClaims, ['jti' => $this->signingKeySid . '-' . $now, 'iss' => $this->signingKeySid, 'sub' => $this->accountSid, 'exp' => $now + $this->ttl, 'grants' => $grants]);
        if ($this->nbf !== null) {
            $payload['nbf'] = $this->nbf;
        }
        return JWT::encode($payload, $this->secret, $algorithm, $header);
    }
}