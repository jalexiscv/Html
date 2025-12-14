<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Say extends TwiML
{
    public function __construct($message, $attributes = [])
    {
        parent::__construct('Say', $message, $attributes);
    }

    public function break_($attributes = []): SsmlBreak
    {
        return $this->nest(new SsmlBreak($attributes));
    }

    public function emphasis($words, $attributes = []): SsmlEmphasis
    {
        return $this->nest(new SsmlEmphasis($words, $attributes));
    }

    public function lang($words, $attributes = []): SsmlLang
    {
        return $this->nest(new SsmlLang($words, $attributes));
    }

    public function p($words): SsmlP
    {
        return $this->nest(new SsmlP($words));
    }

    public function phoneme($words, $attributes = []): SsmlPhoneme
    {
        return $this->nest(new SsmlPhoneme($words, $attributes));
    }

    public function prosody($words, $attributes = []): SsmlProsody
    {
        return $this->nest(new SsmlProsody($words, $attributes));
    }

    public function s($words): SsmlS
    {
        return $this->nest(new SsmlS($words));
    }

    public function say_As($words, $attributes = []): SsmlSayAs
    {
        return $this->nest(new SsmlSayAs($words, $attributes));
    }

    public function sub($words, $attributes = []): SsmlSub
    {
        return $this->nest(new SsmlSub($words, $attributes));
    }

    public function w($words, $attributes = []): SsmlW
    {
        return $this->nest(new SsmlW($words, $attributes));
    }

    public function setVoice($voice): self
    {
        return $this->setAttribute('voice', $voice);
    }

    public function setLoop($loop): self
    {
        return $this->setAttribute('loop', $loop);
    }

    public function setLanguage($language): self
    {
        return $this->setAttribute('language', $language);
    }
}