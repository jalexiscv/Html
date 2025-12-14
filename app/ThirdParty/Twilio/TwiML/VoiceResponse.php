<?php

namespace Twilio\TwiML;
class VoiceResponse extends TwiML
{
    public function __construct()
    {
        parent::__construct('Response', null);
    }

    public function connect($attributes = []): Voice\Connect
    {
        return $this->nest(new Voice\Connect($attributes));
    }

    public function dial($number = null, $attributes = []): Voice\Dial
    {
        return $this->nest(new Voice\Dial($number, $attributes));
    }

    public function echo_(): Voice\Echo_
    {
        return $this->nest(new Voice\Echo_());
    }

    public function enqueue($name = null, $attributes = []): Voice\Enqueue
    {
        return $this->nest(new Voice\Enqueue($name, $attributes));
    }

    public function gather($attributes = []): Voice\Gather
    {
        return $this->nest(new Voice\Gather($attributes));
    }

    public function hangup(): Voice\Hangup
    {
        return $this->nest(new Voice\Hangup());
    }

    public function leave(): Voice\Leave
    {
        return $this->nest(new Voice\Leave());
    }

    public function pause($attributes = []): Voice\Pause
    {
        return $this->nest(new Voice\Pause($attributes));
    }

    public function play($url = null, $attributes = []): Voice\Play
    {
        return $this->nest(new Voice\Play($url, $attributes));
    }

    public function queue($name, $attributes = []): Voice\Queue
    {
        return $this->nest(new Voice\Queue($name, $attributes));
    }

    public function record($attributes = []): Voice\Record
    {
        return $this->nest(new Voice\Record($attributes));
    }

    public function redirect($url, $attributes = []): Voice\Redirect
    {
        return $this->nest(new Voice\Redirect($url, $attributes));
    }

    public function reject($attributes = []): Voice\Reject
    {
        return $this->nest(new Voice\Reject($attributes));
    }

    public function say($message, $attributes = []): Voice\Say
    {
        return $this->nest(new Voice\Say($message, $attributes));
    }

    public function sms($message, $attributes = []): Voice\Sms
    {
        return $this->nest(new Voice\Sms($message, $attributes));
    }

    public function pay($attributes = []): Voice\Pay
    {
        return $this->nest(new Voice\Pay($attributes));
    }

    public function prompt($attributes = []): Voice\Prompt
    {
        return $this->nest(new Voice\Prompt($attributes));
    }

    public function start($attributes = []): Voice\Start
    {
        return $this->nest(new Voice\Start($attributes));
    }

    public function stop(): Voice\Stop
    {
        return $this->nest(new Voice\Stop());
    }

    public function refer($attributes = []): Voice\Refer
    {
        return $this->nest(new Voice\Refer($attributes));
    }
}