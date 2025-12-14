<?php

namespace Higgs\HTTP;
interface RequestInterface extends OutgoingRequestInterface
{
    public function getIPAddress(): string;

    public function isValidIP(string $ip, ?string $which = null): bool;

    public function getServer($index = null, $filter = null);
}