<?php

namespace Higgs\Security;

use Higgs\HTTP\RequestInterface;
use Higgs\Security\Exceptions\SecurityException;

interface SecurityInterface
{
    public function verify(RequestInterface $request);

    public function getHash(): ?string;

    public function getTokenName(): string;

    public function getHeaderName(): string;

    public function getCookieName(): string;

    public function isExpired(): bool;

    public function shouldRedirect(): bool;

    public function sanitizeFilename(string $str, bool $relativePath = false): string;
}