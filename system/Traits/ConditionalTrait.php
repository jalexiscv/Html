<?php

namespace Higgs\Traits;
trait ConditionalTrait
{
    public function when($condition, callable $callback, ?callable $defaultCallback = null): self
    {
        if ($condition) {
            $callback($this, $condition);
        } elseif ($defaultCallback) {
            $defaultCallback($this);
        }
        return $this;
    }

    public function whenNot($condition, callable $callback, ?callable $defaultCallback = null): self
    {
        if (!$condition) {
            $callback($this, $condition);
        } elseif ($defaultCallback) {
            $defaultCallback($this);
        }
        return $this;
    }
}