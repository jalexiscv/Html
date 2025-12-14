<?php

namespace SendGrid\Mail;

use JsonSerializable;

class MailSettings implements JsonSerializable
{
    private $bcc;
    private $bypass_list_management;
    private $footer;
    private $sandbox_mode;
    private $spam_check;

    public function __construct($bcc_settings = null, $bypass_list_management = null, $footer = null, $sandbox_mode = null, $spam_check = null)
    {
        if (isset($bcc_settings)) {
            $this->setBccSettings($bcc_settings);
        }
        if (isset($bypass_list_management)) {
            $this->setBypassListManagement($bypass_list_management);
        }
        if (isset($footer)) {
            $this->setFooter($footer);
        }
        if (isset($sandbox_mode)) {
            $this->setSandboxMode($sandbox_mode);
        }
        if (isset($spam_check)) {
            $this->setSpamCheck($spam_check);
        }
    }

    public function setBccSettings($enable, $email = null)
    {
        if ($enable instanceof BccSettings) {
            $bcc = $enable;
            $this->bcc = $bcc;
            return;
        }
        if (!is_bool($enable)) {
            throw new TypeException('$enable must be an instance of SendGrid\Mail\BccSettings or of type bool.');
        }
        $this->bcc = new BccSettings($enable, $email);
    }

    public function getBccSettings()
    {
        return $this->bcc;
    }

    public function setBypassListManagement($enable)
    {
        if ($enable instanceof BypassListManagement) {
            $bypass_list_management = $enable;
            $this->bypass_list_management = $bypass_list_management;
            return;
        }
        if (!is_bool($enable)) {
            throw new TypeException('$enable must be an instance of SendGrid\Mail\BypassListManagement or of type bool.');
        }
        $this->bypass_list_management = new BypassListManagement($enable);
        return;
    }

    public function getBypassListManagement()
    {
        return $this->bypass_list_management;
    }

    public function setFooter($enable, $text = null, $html = null)
    {
        if ($enable instanceof Footer) {
            $footer = $enable;
            $this->footer = $footer;
            return;
        }
        $this->footer = new Footer($enable, $text, $html);
        return;
    }

    public function getFooter()
    {
        return $this->footer;
    }

    public function setSandboxMode($enable)
    {
        if ($enable instanceof SandBoxMode) {
            $sandbox_mode = $enable;
            $this->sandbox_mode = $sandbox_mode;
            return;
        }
        $this->sandbox_mode = new SandBoxMode($enable);
        return;
    }

    public function getSandboxMode()
    {
        return $this->sandbox_mode;
    }

    public function enableSandboxMode()
    {
        $this->setSandboxMode(true);
    }

    public function disableSandboxMode()
    {
        $this->setSandboxMode(false);
    }

    public function setSpamCheck($enable, $threshold = null, $post_to_url = null)
    {
        if ($enable instanceof SpamCheck) {
            $spam_check = $enable;
            $this->spam_check = $spam_check;
            return;
        }
        $this->spam_check = new SpamCheck($enable, $threshold, $post_to_url);
        return;
    }

    public function getSpamCheck()
    {
        return $this->spam_check;
    }

    public function jsonSerialize()
    {
        return array_filter(['bcc' => $this->getBccSettings(), 'bypass_list_management' => $this->getBypassListManagement(), 'footer' => $this->getFooter(), 'sandbox_mode' => $this->getSandboxMode(), 'spam_check' => $this->getSpamCheck()], function ($value) {
            return $value !== null;
        }) ?: null;
    }
}
