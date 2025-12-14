<?php

namespace SendGrid\Mail;

use JsonSerializable;

class Personalization implements JsonSerializable
{
    private $tos;
    private $ccs;
    private $bccs;
    private $subject;
    private $headers;
    private $substitutions;
    private $dynamic_template_data;
    private $has_dynamic_template = false;
    private $custom_args;
    private $send_at;

    public function addTo($email)
    {
        $this->tos[] = $email;
    }

    public function addCc($email)
    {
        $this->ccs[] = $email;
    }

    public function addBcc($email)
    {
        $this->bccs[] = $email;
    }

    public function addHeader($header)
    {
        $this->headers[$header->getKey()] = $header->getValue();
    }

    public function addDynamicTemplateData($data, $value = null)
    {
        $this->addSubstitution($data, $value);
    }

    public function addSubstitution($substitution, $value = null)
    {
        if (!($substitution instanceof Substitution)) {
            $key = $substitution;
            $substitution = new Substitution($key, $value);
        }
        $this->substitutions[$substitution->getKey()] = $substitution->getValue();
    }

    public function getDynamicTemplateData()
    {
        return $this->getSubstitutions();
    }

    public function getSubstitutions()
    {
        return $this->substitutions;
    }

    public function addCustomArg($custom_arg)
    {
        $this->custom_args[$custom_arg->getKey()] = (string)$custom_arg->getValue();
    }

    public function jsonSerialize(): mixed
    {
        if ($this->getHasDynamicTemplate() == true) {
            $dynamic_substitutions = $this->getSubstitutions();
            $substitutions = null;
        } else {
            $substitutions = $this->getSubstitutions();
            $dynamic_substitutions = null;
        }
        return array_filter(['to' => $this->getTos(), 'cc' => $this->getCcs(), 'bcc' => $this->getBccs(), 'subject' => $this->getSubject(), 'headers' => $this->getHeaders(), 'substitutions' => $substitutions, 'dynamic_template_data' => $dynamic_substitutions, 'custom_args' => $this->getCustomArgs(), 'send_at' => $this->getSendAt()], function ($value) {
            return $value !== null;
        }) ?: null;
    }

    public function getHasDynamicTemplate()
    {
        return $this->has_dynamic_template;
    }

    public function setHasDynamicTemplate($has_dynamic_template)
    {
        if (is_bool($has_dynamic_template) != true) {
            throw new TypeException('$has_dynamic_template must be an instance of bool');
        }
        $this->has_dynamic_template = $has_dynamic_template;
    }

    public function getTos()
    {
        return $this->tos;
    }

    public function getCcs()
    {
        return $this->ccs;
    }

    public function getBccs()
    {
        return $this->bccs;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        if (!($subject instanceof Subject)) {
            throw new TypeException('$subject must be an instance of SendGrid\Mail\Subject');
        }
        $this->subject = $subject;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getCustomArgs()
    {
        return $this->custom_args;
    }

    public function getSendAt()
    {
        return $this->send_at;
    }

    public function setSendAt($send_at)
    {
        if (!($send_at instanceof SendAt)) {
            throw new TypeException('$send_at must be an instance of SendGrid\Mail\SendAt');
        }
        $this->send_at = $send_at;
    }
}
