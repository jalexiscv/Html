<?php

namespace Higgs\Exceptions;
interface HasExitCodeInterface
{
    public function getExitCode(): int;
}