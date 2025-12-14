<?php

namespace SendGrid\Mail;

use JsonSerializable;

class Mail implements JsonSerializable
{
    const VERSION = "7.0.0";
    private $from;
    private $subject;
    private $contents;
    private $attachments;
    private $template_id;
    private $sections;
    private $headers;
    private $categories;
    private $custom_args;
    private $substitutions;
    private $send_at;
    private $batch_id;
    private $asm;
    private $ip_pool_name;
    private $mail_settings;
    private $tracking_settings;
    private $reply_to;
    private $personalization;

    public function __construct($from = null, $to = null, $subject = null, $plainTextContent = null, $htmlContent = null, array $globalSubstitutions = null)
    {
        if (!isset($from) && !isset($to) && !isset($subject) && !isset($plainTextContent) && !isset($htmlContent) && !isset($globalSubstitutions)) {
            $this->personalization[] = new Personalization();
            return;
        }
        if (isset($from)) {
            $this->setFrom($from);
        }
        if (isset($to)) {
            if (!is_array($to)) {
                $to = [$to];
            }
            $subjectCount = 0;
            $personalization = new Personalization();
            foreach ($to as $email) {
                if ($subs = $email->getSubstitutions()) {
                    $personalization = new Personalization();
                }
                $personalization->addTo($email);
                if ($subs = $email->getSubstitutions()) {
                    foreach ($subs as $key => $value) {
                        $personalization->addSubstitution($key, $value);
                    }
                }
                if ($email->getSubject()) {
                    $personalization->setSubject($email->getSubject());
                }
                if (is_array($subject)) {
                    if ($subjectCount < sizeof($subject)) {
                        $personalization->setSubject($subject[$subjectCount]);
                    }
                    $subjectCount++;
                }
                if (is_array($globalSubstitutions)) {
                    foreach ($globalSubstitutions as $key => $value) {
                        $personalization->addSubstitution($key, $value);
                    }
                }
                if ($subs = $email->getSubstitutions()) {
                    $this->addPersonalization($personalization);
                }
            }
            if (!$subs = $email->getSubstitutions()) {
                $this->addPersonalization($personalization);
            }
        }
        if (isset($subject)) {
            if (!is_array($subject)) {
                $this->setSubject($subject);
            }
        }
        if (isset($plainTextContent)) {
            $this->addContent($plainTextContent);
        }
        if (isset($htmlContent)) {
            $this->addContent($htmlContent);
        }
    }

    public function getSubstitutions($personalizationIndex = 0)
    {
        return $this->personalization[$personalizationIndex]->getSubstitutions();
    }

    public function addTo($to, $name = null, $substitutions = null, $personalizationIndex = null, $personalization = null)
    {
        if ($to instanceof To) {
            $name = $to->getName();
            $substitutions = $to->getSubstitutions();
            $to = $to->getEmailAddress();
        }
        $this->addRecipientEmail("To", $to, $name, $substitutions, $personalizationIndex, $personalization);
    }

    private function addRecipientEmail($emailType, $email, $name = null, $substitutions = null, $personalizationIndex = null, $personalization = null)
    {
        $personalizationFunctionCall = "add" . $emailType;
        $emailType = "\SendGrid\Mail\\" . $emailType;
        if (!($email instanceof $emailType)) {
            $email = new $emailType($email, $name, $substitutions);
        }
        if ($personalization != null) {
            $personalization->$personalizationFunctionCall($email);
            if ($subs = $email->getSubstitutions()) {
                foreach ($subs as $key => $value) {
                    $personalization->addSubstitution($key, $value);
                }
            }
            $this->addPersonalization($personalization);
            return;
        } else {
            if (isset($personalizationIndex) && !isset($this->personalization[$personalizationIndex])) {
                $this->personalization[$personalizationIndex] = new Personalization();
            }
            if ($this->personalization[0] != null && $personalizationIndex == 0) {
                $this->personalization[0]->$personalizationFunctionCall($email);
                if ($subs = $email->getSubstitutions()) {
                    foreach ($subs as $key => $value) {
                        $this->personalization[0]->addSubstitution($key, $value);
                    }
                }
                return;
            } else if ($this->personalization[$personalizationIndex] != null) {
                $this->personalization[$personalizationIndex]->$personalizationFunctionCall($email);
                if ($subs = $email->getSubstitutions()) {
                    foreach ($subs as $key => $value) {
                        $this->personalization[$personalizationIndex]->addSubstitution($key, $value);
                    }
                }
                return;
            } else {
                $personalization = new Personalization();
                $personalization->$personalizationFunctionCall($email);
                if ($subs = $email->getSubstitutions()) {
                    foreach ($subs as $key => $value) {
                        $personalization->addSubstitution($key, $value);
                    }
                }
                if (($personalizationIndex != 0) && ($this->getPersonalizationCount() <= $personalizationIndex)) {
                    $this->personalization[$personalizationIndex] = $personalization;
                } else {
                    $this->addPersonalization($personalization);
                }
                return;
            }
        }
    }

    public function addSubstitution($key, $value = null, $personalizationIndex = null, $personalization = null)
    {
        $substitution = null;
        if ($key instanceof Substitution) {
            $s = $key;
            $substitution = new Substitution($s->getKey(), $s->getValue());
        } else {
            $substitution = new Substitution($key, $value);
        }
        if ($personalization != null) {
            $personalization->addSubstitution($substitution);
            $this->addPersonalization($personalization);
            return;
        } else {
            if ($this->personalization[0] != null) {
                $this->personalization[0]->addSubstitution($substitution);
            } else if ($this->personalization[$personalizationIndex] != null) {
                $this->personalization[$personalizationIndex]->addSubstitution($substitution);
            } else {
                $personalization = new Personalization();
                $personalization->addSubstitution($substitution);
                if (($personalizationIndex != 0) && ($this->getPersonalizationCount() <= $personalizationIndex)) {
                    $this->personalization[$personalizationIndex] = $personalization;
                } else {
                    $this->addPersonalization($personalization);
                }
            }
            return;
        }
    }

    public function addPersonalization($personalization)
    {
        $this->personalization[] = $personalization;
    }

    public function getPersonalizationCount()
    {
        return count($this->personalization);
    }

    public function getSubject($personalizationIndex = 0)
    {
        return $this->personalization[$personalizationIndex]->getSubject();
    }

    public function setSubject($subject, $personalizationIndex = null, $personalization = null)
    {
        if (!($subject instanceof Subject)) {
            $subject = new Subject($subject);
        }
        if ($personalization != null) {
            $personalization->setSubject($subject);
            $this->addPersonalization($personalization);
            return;
        }
        if ($personalizationIndex != null) {
            $this->personalization[$personalizationIndex]->setSubject($subject);
            return;
        }
        $this->setGlobalSubject($subject);
        return;
    }

    public function addContent($type, $value = null)
    {
        if ($type instanceof Content) {
            $content = $type;
        } else {
            $content = new Content($type, $value);
        }
        $this->contents[] = $content;
    }

    public function addTos($toEmails, $personalizationIndex = null, $personalization = null)
    {
        $this->addRecipientEmails("To", $toEmails, $personalizationIndex, $personalization);
    }

    private function addRecipientEmails($emailType, $emails, $personalizationIndex = null, $personalization = null)
    {
        $emailFunctionCall = "add" . $emailType;
        if (current($emails) instanceof EmailAddress) {
            foreach ($emails as $email) {
                $this->$emailFunctionCall($email, $name = null, $personalizationIndex, $personalization);
            }
        } else {
            foreach ($emails as $email => $name) {
                $this->$emailFunctionCall($email, $name, $personalizationIndex, $personalization);
            }
        }
    }

    public function addCc($cc, $name = null, $personalizationIndex = null, $personalization = null)
    {
        if ($cc instanceof Cc) {
            $name = $cc->getName();
            $cc = $cc->getEmailAddress();
        }
        $this->addRecipientEmail("Cc", $cc, $name, $personalizationIndex, $personalization);
    }

    public function addCcs($ccEmails, $personalizationIndex = null, $personalization = null)
    {
        $this->addRecipientEmails("Cc", $ccEmails, $personalizationIndex, $personalization);
    }

    public function addBcc($bcc, $name = null, $personalizationIndex = null, $personalization = null)
    {
        if ($bcc instanceof Bcc) {
            $name = $bcc->getName();
            $bcc = $bcc->getEmailAddress();
        }
        $this->addRecipientEmail("Bcc", $bcc, $name, $personalizationIndex, $personalization);
    }

    public function addBccs($bccEmails, $personalizationIndex = null, $personalization = null)
    {
        $this->addRecipientEmails("Bcc", $bccEmails, $personalizationIndex, $personalization);
    }

    public function addHeaders($headers, $personalizationIndex = null, $personalization = null)
    {
        if (current($headers) instanceof Header) {
            foreach ($headers as $header) {
                $this->addHeader($header);
            }
        } else {
            foreach ($headers as $key => $value) {
                $this->addHeader($key, $value, $personalizationIndex, $personalization);
            }
        }
    }

    public function addHeader($key, $value = null, $personalizationIndex = null, $personalization = null)
    {
        $header = null;
        if ($key instanceof Header) {
            $h = $key;
            $header = new Header($h->getKey(), $h->getValue());
        } else {
            $header = new Header($key, $value);
        }
        if ($personalization != null) {
            $personalization->addHeader($header);
            $this->addPersonalization($personalization);
            return;
        } else {
            if ($this->personalization[0] != null) {
                $this->personalization[0]->addHeader($header);
            } else if ($this->personalization[$personalizationIndex] != null) {
                $this->personalization[$personalizationIndex]->addHeader($header);
            } else {
                $personalization = new Personalization();
                $personalization->addHeader($header);
                if (($personalizationIndex != 0) && ($this->getPersonalizationCount() <= $personalizationIndex)) {
                    $this->personalization[$personalizationIndex] = $personalization;
                } else {
                    $this->addPersonalization($personalization);
                }
            }
            return;
        }
    }

    public function getHeaders($personalizationIndex = 0)
    {
        return $this->personalization[$personalizationIndex]->getHeaders();
    }

    public function addDynamicTemplateData($key, $value = null, $personalizationIndex = null, $personalization = null)
    {
        $this->addSubstitution($key, $value, $personalizationIndex, $personalization);
    }

    public function addDynamicTemplateDatas($datas, $personalizationIndex = null, $personalization = null)
    {
        $this->addSubstitutions($datas);
    }

    public function addSubstitutions($substitutions, $personalizationIndex = null, $personalization = null)
    {
        if (current($substitutions) instanceof Substitution) {
            foreach ($substitutions as $substitution) {
                $this->addSubstitution($substitution);
            }
        } else {
            foreach ($substitutions as $key => $value) {
                $this->addSubstitution($key, $value, $personalizationIndex, $personalization);
            }
        }
    }

    public function getDynamicTemplateDatas($personalizationIndex = 0)
    {
        return $this->getSubstitutions($personalizationIndex);
    }

    public function addCustomArgs($custom_args, $personalizationIndex = null, $personalization = null)
    {
        if (current($custom_args) instanceof CustomArg) {
            foreach ($custom_args as $custom_arg) {
                $this->addCustomArg($custom_arg);
            }
        } else {
            foreach ($custom_args as $key => $value) {
                $this->addCustomArg($key, $value, $personalizationIndex, $personalization);
            }
        }
    }

    public function addCustomArg($key, $value = null, $personalizationIndex = null, $personalization = null)
    {
        $custom_arg = null;
        if ($key instanceof CustomArg) {
            $ca = $key;
            $custom_arg = new CustomArg($ca->getKey(), $ca->getValue());
        } else {
            $custom_arg = new CustomArg($key, $value);
        }
        if ($personalization != null) {
            $personalization->addCustomArg($custom_arg);
            $this->addPersonalization($personalization);
            return;
        } else {
            if ($this->personalization[0] != null) {
                $this->personalization[0]->addCustomArg($custom_arg);
            } else if ($this->personalization[$personalizationIndex] != null) {
                $this->personalization[$personalizationIndex]->addCustomArg($custom_arg);
            } else {
                $personalization = new Personalization();
                $personalization->addCustomArg($custom_arg);
                if (($personalizationIndex != 0) && ($this->getPersonalizationCount() <= $personalizationIndex)) {
                    $this->personalization[$personalizationIndex] = $personalization;
                } else {
                    $this->addPersonalization($personalization);
                }
            }
            return;
        }
    }

    public function getCustomArgs($personalizationIndex = 0)
    {
        return $this->personalization[$personalizationIndex]->getCustomArgs();
    }

    public function getSendAt($personalizationIndex = 0)
    {
        return $this->personalization[$personalizationIndex]->getSendAt();
    }

    public function setSendAt($send_at, $personalizationIndex = null, $personalization = null)
    {
        if (!($send_at instanceof SendAt)) {
            $send_at = new SendAt($send_at);
        }
        if ($personalization != null) {
            $personalization->setSendAt($send_at);
            $this->addPersonalization($personalization);
            return;
        } else {
            if ($this->personalization[0] != null) {
                $this->personalization[0]->setSendAt($send_at);
                return;
            } else if ($this->personalization[$personalizationIndex] != null) {
                $this->personalization[$personalizationIndex]->setSendAt($send_at);
                return;
            } else {
                $personalization = new Personalization();
                $personalization->setSendAt($send_at);
                if (($personalizationIndex != 0) && ($this->getPersonalizationCount() <= $personalizationIndex)) {
                    $this->personalization[$personalizationIndex] = $personalization;
                } else {
                    $this->addPersonalization($personalization);
                }
                return;
            }
        }
    }

    public function setGlobalSubject($subject)
    {
        if (!($subject instanceof Subject)) {
            $subject = new Subject($subject);
        }
        $this->subject = $subject;
    }

    public function addContents($contents)
    {
        if (current($contents) instanceof Content) {
            foreach ($contents as $content) {
                $this->addContent($content);
            }
        } else {
            foreach ($contents as $key => $value) {
                $this->addContent($key, $value);
            }
        }
    }

    public function addAttachments($attachments)
    {
        foreach ($attachments as $attachment) {
            $this->addAttachment($attachment);
        }
    }

    public function addAttachment($attachment, $type = null, $filename = null, $disposition = null, $content_id = null)
    {
        if (is_array($attachment)) {
            $attachment = new Attachment($attachment[0], $attachment[1], $attachment[2], $attachment[3], $attachment[4]);
        } else if (!($attachment instanceof Attachment)) {
            $attachment = new Attachment($attachment, $type, $filename, $disposition, $content_id);
        }
        $this->attachments[] = $attachment;
    }

    public function addSections($sections)
    {
        if (current($sections) instanceof Section) {
            foreach ($sections as $section) {
                $this->addSection($section);
            }
        } else {
            foreach ($sections as $key => $value) {
                $this->addSection($key, $value);
            }
        }
    }

    public function addSection($key, $value = null)
    {
        if ($key instanceof Section) {
            $section = $key;
            $this->sections[$section->getKey()] = $section->getValue();
            return;
        }
        $this->sections[$key] = (string)$value;
    }

    public function addGlobalHeaders($headers)
    {
        if (current($headers) instanceof Header) {
            foreach ($headers as $header) {
                $this->addGlobalHeader($header);
            }
        } else {
            foreach ($headers as $key => $value) {
                $this->addGlobalHeader($key, $value);
            }
        }
    }

    public function addGlobalHeader($key, $value = null)
    {
        if ($key instanceof Header) {
            $header = $key;
            $this->headers[$header->getKey()] = $header->getValue();
            return;
        }
        $this->headers[$key] = (string)$value;
    }

    public function addGlobalSubstitutions($substitutions)
    {
        if (current($substitutions) instanceof Substitution) {
            foreach ($substitutions as $substitution) {
                $this->addGlobalSubstitution($substitution);
            }
        } else {
            foreach ($substitutions as $key => $value) {
                $this->addGlobalSubstitution($key, $value);
            }
        }
    }

    public function addGlobalSubstitution($key, $value = null)
    {
        if ($key instanceof Substitution) {
            $substitution = $key;
            $this->substitutions[$substitution->getKey()] = $substitution->getValue();
            return;
        }
        $this->substitutions[$key] = $value;
    }

    public function addCategories($categories)
    {
        foreach ($categories as $category) {
            $this->addCategory($category);
        }
        return;
    }

    public function addCategory($category)
    {
        if (!($category instanceof Category)) {
            $category = new Category($category);
        }
        $this->categories[] = $category;
    }

    public function addGlobalCustomArgs($custom_args)
    {
        if (current($custom_args) instanceof CustomArg) {
            foreach ($custom_args as $custom_arg) {
                $this->addGlobalCustomArg($custom_arg);
            }
        } else {
            foreach ($custom_args as $key => $value) {
                $this->addGlobalCustomArg($key, $value);
            }
        }
    }

    public function addGlobalCustomArg($key, $value = null)
    {
        if ($key instanceof CustomArg) {
            $custom_arg = $key;
            $this->custom_args[$custom_arg->getKey()] = $custom_arg->getValue();
            return;
        }
        $this->custom_args[$key] = (string)$value;
    }

    public function setGlobalSendAt($send_at)
    {
        if (!($send_at instanceof SendAt)) {
            $send_at = new SendAt($send_at);
        }
        $this->send_at = $send_at;
    }

    public function setBccSettings($enable, $email = null)
    {
        if (!($this->mail_settings instanceof MailSettings)) {
            $this->mail_settings = new MailSettings();
        }
        $this->mail_settings->setBccSettings($enable, $email);
    }

    public function enableBypassListManagement()
    {
        if (!$this->mail_settings instanceof MailSettings) {
            $this->mail_settings = new MailSettings();
        }
        $this->mail_settings->setBypassListManagement(true);
    }

    public function disableBypassListManagement()
    {
        if (!($this->mail_settings instanceof MailSettings)) {
            $this->mail_settings = new MailSettings();
        }
        $this->mail_settings->setBypassListManagement(false);
    }

    public function setFooter($enable = null, $text = null, $html = null)
    {
        if (!$this->mail_settings instanceof MailSettings) {
            $this->mail_settings = new MailSettings();
        }
        $this->mail_settings->setFooter($enable, $text, $html);
    }

    public function enableSandBoxMode()
    {
        if (!($this->mail_settings instanceof MailSettings)) {
            $this->mail_settings = new MailSettings();
        }
        $this->mail_settings->setSandBoxMode(true);
    }

    public function disableSandBoxMode()
    {
        if (!($this->mail_settings instanceof MailSettings)) {
            $this->mail_settings = new MailSettings();
        }
        $this->mail_settings->setSandBoxMode(false);
    }

    public function setSpamCheck($enable = null, $threshold = null, $post_to_url = null)
    {
        if (!$this->mail_settings instanceof MailSettings) {
            $this->mail_settings = new MailSettings();
        }
        $this->mail_settings->setSpamCheck($enable, $threshold, $post_to_url);
    }

    public function setClickTracking($enable = null, $enable_text = null)
    {
        if (!($this->tracking_settings instanceof TrackingSettings)) {
            $this->tracking_settings = new TrackingSettings();
        }
        $this->tracking_settings->setClickTracking($enable, $enable_text);
    }

    public function setOpenTracking($enable = null, $substitution_tag = null)
    {
        if (!($this->tracking_settings instanceof TrackingSettings)) {
            $this->tracking_settings = new TrackingSettings();
        }
        $this->tracking_settings->setOpenTracking($enable, $substitution_tag);
    }

    public function setSubscriptionTracking($enable = null, $text = null, $html = null, $substitution_tag = null)
    {
        if (!($this->tracking_settings instanceof TrackingSettings)) {
            $this->tracking_settings = new TrackingSettings();
        }
        $this->tracking_settings->setSubscriptionTracking($enable, $text, $html, $substitution_tag);
    }

    public function setGanalytics($enable = null, $utm_source = null, $utm_medium = null, $utm_term = null, $utm_content = null, $utm_campaign = null)
    {
        if (!($this->tracking_settings instanceof TrackingSettings)) {
            $this->tracking_settings = new TrackingSettings();
        }
        $this->tracking_settings->setGanalytics($enable, $utm_source, $utm_medium, $utm_term, $utm_content, $utm_campaign);
    }

    public function jsonSerialize(): mixed
    {
        $template_id = $this->getTemplateId();
        if ($template_id != null) {
            if (substr((string)$template_id->getTemplateId(), 0, 2) == "d-") {
                foreach ($this->personalization as $personalization) {
                    $personalization->setHasDynamicTemplate(true);
                }
            }
        }
        return array_filter(['personalizations' => $this->getPersonalizations(), 'from' => $this->getFrom(), 'reply_to' => $this->getReplyTo(), 'subject' => $this->getGlobalSubject(), 'content' => $this->getContents(), 'attachments' => $this->getAttachments(), 'template_id' => $this->getTemplateId(), 'sections' => $this->getSections(), 'headers' => $this->getGlobalHeaders(), 'categories' => $this->getCategories(), 'custom_args' => $this->getGlobalCustomArgs(), 'send_at' => $this->getGlobalSendAt(), 'batch_id' => $this->getBatchId(), 'asm' => $this->getASM(), 'ip_pool_name' => $this->getIpPoolName(), 'substitutions' => $this->getGlobalSubstitutions(), 'mail_settings' => $this->getMailSettings(), 'tracking_settings' => $this->getTrackingSettings()], function ($value) {
            return $value !== null;
        }) ?: null;
    }

    public function getTemplateId()
    {
        return $this->template_id;
    }

    public function setTemplateId($template_id)
    {
        if (!($template_id instanceof TemplateId)) {
            $template_id = new TemplateId($template_id);
        }
        $this->template_id = $template_id;
    }

    public function getPersonalizations()
    {
        return $this->personalization;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function setFrom($email, $name = null)
    {
        if ($email instanceof From) {
            $this->from = $email;
        } else {
            if (is_string($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->from = new From($email, $name);
            } else {
                throw new TypeException('$email must be valid and of type string.');
            }
        }
        return;
    }

    public function getReplyTo()
    {
        return $this->reply_to;
    }

    public function setReplyTo($email, $name = null)
    {
        if ($email instanceof ReplyTo) {
            $this->reply_to = $email;
        } else {
            $this->reply_to = new ReplyTo($email, $name);
        }
    }

    public function getGlobalSubject()
    {
        return $this->subject;
    }

    public function getContents()
    {
        if ($this->contents) {
            if ($this->contents[0]->getType() !== 'text/plain' && count($this->contents) > 1) {
                foreach ($this->contents as $key => $value) {
                    if ($value->getType() == 'text/plain') {
                        $plain_content = $value;
                        unset($this->contents[$key]);
                        break;
                    }
                }
                array_unshift($this->contents, $plain_content);
            }
        }
        return $this->contents;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }

    public function getSections()
    {
        return $this->sections;
    }

    public function getGlobalHeaders()
    {
        return $this->headers;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function getGlobalCustomArgs()
    {
        return $this->custom_args;
    }

    public function getGlobalSendAt()
    {
        return $this->send_at;
    }

    public function getBatchId()
    {
        return $this->batch_id;
    }

    public function setBatchId($batch_id)
    {
        if (!($batch_id instanceof BatchId)) {
            $batch_id = new BatchId($batch_id);
        }
        $this->batch_id = $batch_id;
    }

    public function getAsm()
    {
        return $this->asm;
    }

    public function setAsm($group_id, $groups_to_display = null)
    {
        if ($group_id instanceof Asm) {
            $asm = $group_id;
            $this->asm = $asm;
        } else {
            $this->asm = new Asm($group_id, $groups_to_display);
        }
    }

    public function getIpPoolName()
    {
        return $this->ip_pool_name;
    }

    public function setIpPoolName($ip_pool_name)
    {
        if ($ip_pool_name instanceof IpPoolName) {
            $this->ip_pool_name = $ip_pool_name->getIpPoolName();
        } else {
            $this->ip_pool_name = new IpPoolName($ip_pool_name);
        }
    }

    public function getGlobalSubstitutions()
    {
        return $this->substitutions;
    }

    public function getMailSettings()
    {
        return $this->mail_settings;
    }

    public function setMailSettings($mail_settings)
    {
        if (!($mail_settings instanceof MailSettings)) {
            throw new TypeException('$mail_settings must be an instance of SendGrid\Mail\MailSettings');
        }
        $this->mail_settings = $mail_settings;
    }

    public function getTrackingSettings()
    {
        return $this->tracking_settings;
    }

    public function setTrackingSettings($tracking_settings)
    {
        if (!($tracking_settings instanceof TrackingSettings)) {
            throw new TypeException('$tracking_settings must be an instance of SendGrid\Mail\TrackingSettings');
        }
        $this->tracking_settings = $tracking_settings;
    }
}
