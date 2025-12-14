<?php

namespace SendGrid\Mail;

use JsonSerializable;

class TemplateId implements JsonSerializable
{
    private $template_id;

    public function __construct($template_id = null)
    {
        if (isset($template_id)) {
            $this->setTemplateId($template_id);
        }
    }

    public function setTemplateId($template_id)
    {
        if (!is_string($template_id)) {
            throw new TypeException('$template_id must be of type string.');
        }
        $this->template_id = $template_id;
    }

    public function getTemplateId()
    {
        return $this->template_id;
    }

    public function jsonSerialize()
    {
        return $this->getTemplateId();
    }
}
