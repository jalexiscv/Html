<?php

namespace Higgs\Modules;
class Modules
{
    private bool $enabled = true;
    private bool $discoverInComposer = true;
    private array $aliases = [];

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function shouldDiscoverInComposer(): bool
    {
        return $this->discoverInComposer;
    }

    public function setDiscoverInComposer(bool $discoverInComposer): void
    {
        $this->discoverInComposer = $discoverInComposer;
    }

    public function getAliases(): array
    {
        return $this->aliases;
    }

    public function setAliases(array $aliases): void
    {
        $this->aliases = $aliases;
    }

    public function shouldDiscover(string $alias): bool
    {
        if (!is_string($alias)) {
            throw new \InvalidArgumentException('$alias must be a string');
        }
        if (!$this->enabled) {
            return false;
        }
        return in_array(strtolower($alias), $this->aliases, true);
    }
} ?>