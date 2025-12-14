<?php

namespace MongoDB\Operation;

use MongoDB\Driver\Server;

interface Executable
{
    public function execute(Server $server);
}