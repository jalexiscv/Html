<?php

namespace Higgs\HTTP;
class Header
{
    protected $name;
    protected $value;

    public function __construct(string $name, $value = null)
    {
        $this->name = $name;
        $this->setValue($value);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value = null)
    {
        $this->value = is_array($value) ? $value : (string)$value;
        return $this;
    }

    public function appendValue($value = null)
    {
        if ($value === null) {
            return $this;
        }
        if (!is_array($this->value)) {
            $this->value = [$this->value];
        }
        if (!in_array($value, $this->value, true)) {
            $this->value[] = is_array($value) ? $value : (string)$value;
        }
        return $this;
    }

    public function prependValue($value = null)
    {
        if ($value === null) {
            return $this;
        }
        if (!is_array($this->value)) {
            $this->value = [$this->value];
        }
        array_unshift($this->value, $value);
        return $this;
    }

    public function __toString(): string
    {
        return $this->name . ': ' . $this->getValueLine();
    }

    public function getValueLine(): string
    {
        if (is_string($this->value)) {
            return $this->value;
        }
        if (!is_array($this->value)) {
            return '';
        }
        $options = [];
        foreach ($this->value as $key => $value) {
            if (is_string($key) && !is_array($value)) {
                $options[] = $key . '=' . $value;
            } elseif (is_array($value)) {
                $key = key($value);
                $options[] = $key . '=' . $value[$key];
            } elseif (is_numeric($key)) {
                $options[] = $value;
            }
        }
        return implode(', ', $options);
    }
}