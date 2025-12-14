<?php

namespace MongoDB\Operation;

use MongoDB\Driver\Server;

interface Explainable extends Executable
{
    public function getCommandDocument(Server $server);
}