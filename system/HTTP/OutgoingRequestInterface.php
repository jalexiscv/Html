<?php

namespace Higgs\HTTP;

use InvalidArgumentException;

interface OutgoingRequestInterface extends MessageInterface
{
    public function getMethod(bool $upper = false): string;

    public function withMethod($method);

    public function getUri();

    public function withUri(URI $uri, $preserveHost = false);
}