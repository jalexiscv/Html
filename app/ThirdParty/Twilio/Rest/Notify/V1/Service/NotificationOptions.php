<?php

namespace Twilio\Rest\Notify\V1\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class NotificationOptions
{
    public static function create(array $identity = Values::ARRAY_NONE, array $tag = Values::ARRAY_NONE, string $body = Values::NONE, string $priority = Values::NONE, int $ttl = Values::NONE, string $title = Values::NONE, string $sound = Values::NONE, string $action = Values::NONE, array $data = Values::ARRAY_NONE, array $apn = Values::ARRAY_NONE, array $gcm = Values::ARRAY_NONE, array $sms = Values::ARRAY_NONE, array $facebookMessenger = Values::ARRAY_NONE, array $fcm = Values::ARRAY_NONE, array $segment = Values::ARRAY_NONE, array $alexa = Values::ARRAY_NONE, array $toBinding = Values::ARRAY_NONE, string $deliveryCallbackUrl = Values::NONE): CreateNotificationOptions
    {
        return new CreateNotificationOptions($identity, $tag, $body, $priority, $ttl, $title, $sound, $action, $data, $apn, $gcm, $sms, $facebookMessenger, $fcm, $segment, $alexa, $toBinding, $deliveryCallbackUrl);
    }
}

class CreateNotificationOptions extends Options
{
    public function __construct(array $identity = Values::ARRAY_NONE, array $tag = Values::ARRAY_NONE, string $body = Values::NONE, string $priority = Values::NONE, int $ttl = Values::NONE, string $title = Values::NONE, string $sound = Values::NONE, string $action = Values::NONE, array $data = Values::ARRAY_NONE, array $apn = Values::ARRAY_NONE, array $gcm = Values::ARRAY_NONE, array $sms = Values::ARRAY_NONE, array $facebookMessenger = Values::ARRAY_NONE, array $fcm = Values::ARRAY_NONE, array $segment = Values::ARRAY_NONE, array $alexa = Values::ARRAY_NONE, array $toBinding = Values::ARRAY_NONE, string $deliveryCallbackUrl = Values::NONE)
    {
        $this->options['identity'] = $identity;
        $this->options['tag'] = $tag;
        $this->options['body'] = $body;
        $this->options['priority'] = $priority;
        $this->options['ttl'] = $ttl;
        $this->options['title'] = $title;
        $this->options['sound'] = $sound;
        $this->options['action'] = $action;
        $this->options['data'] = $data;
        $this->options['apn'] = $apn;
        $this->options['gcm'] = $gcm;
        $this->options['sms'] = $sms;
        $this->options['facebookMessenger'] = $facebookMessenger;
        $this->options['fcm'] = $fcm;
        $this->options['segment'] = $segment;
        $this->options['alexa'] = $alexa;
        $this->options['toBinding'] = $toBinding;
        $this->options['deliveryCallbackUrl'] = $deliveryCallbackUrl;
    }

    public function setIdentity(array $identity): self
    {
        $this->options['identity'] = $identity;
        return $this;
    }

    public function setTag(array $tag): self
    {
        $this->options['tag'] = $tag;
        return $this;
    }

    public function setBody(string $body): self
    {
        $this->options['body'] = $body;
        return $this;
    }

    public function setPriority(string $priority): self
    {
        $this->options['priority'] = $priority;
        return $this;
    }

    public function setTtl(int $ttl): self
    {
        $this->options['ttl'] = $ttl;
        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->options['title'] = $title;
        return $this;
    }

    public function setSound(string $sound): self
    {
        $this->options['sound'] = $sound;
        return $this;
    }

    public function setAction(string $action): self
    {
        $this->options['action'] = $action;
        return $this;
    }

    public function setData(array $data): self
    {
        $this->options['data'] = $data;
        return $this;
    }

    public function setApn(array $apn): self
    {
        $this->options['apn'] = $apn;
        return $this;
    }

    public function setGcm(array $gcm): self
    {
        $this->options['gcm'] = $gcm;
        return $this;
    }

    public function setSms(array $sms): self
    {
        $this->options['sms'] = $sms;
        return $this;
    }

    public function setFacebookMessenger(array $facebookMessenger): self
    {
        $this->options['facebookMessenger'] = $facebookMessenger;
        return $this;
    }

    public function setFcm(array $fcm): self
    {
        $this->options['fcm'] = $fcm;
        return $this;
    }

    public function setSegment(array $segment): self
    {
        $this->options['segment'] = $segment;
        return $this;
    }

    public function setAlexa(array $alexa): self
    {
        $this->options['alexa'] = $alexa;
        return $this;
    }

    public function setToBinding(array $toBinding): self
    {
        $this->options['toBinding'] = $toBinding;
        return $this;
    }

    public function setDeliveryCallbackUrl(string $deliveryCallbackUrl): self
    {
        $this->options['deliveryCallbackUrl'] = $deliveryCallbackUrl;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Notify.V1.CreateNotificationOptions ' . $options . ']';
    }
}