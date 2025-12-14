<?php

namespace SendGrid\Mail;

use JsonSerializable;

class Category implements JsonSerializable
{
    private $category;

    public function __construct($category = null)
    {
        if (isset($category)) {
            $this->setCategory($category);
        }
    }

    public function setCategory($category)
    {
        if (!is_string($category)) {
            throw new TypeException('$category must be of type string.');
        }
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function jsonSerialize()
    {
        return $this->getCategory();
    }
}
