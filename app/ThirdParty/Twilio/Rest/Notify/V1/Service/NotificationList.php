<?php

namespace Twilio\Rest\Notify\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function rawurlencode;

class NotificationList extends ListResource
{
    public function __construct(Version $version, string $serviceSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Notifications';
    }

    public function create(array $options = []): NotificationInstance
    {
        $options = new Values($options);
        $data = Values::of(['Identity' => Serialize::map($options['identity'], function ($e) {
            return $e;
        }), 'Tag' => Serialize::map($options['tag'], function ($e) {
            return $e;
        }), 'Body' => $options['body'], 'Priority' => $options['priority'], 'Ttl' => $options['ttl'], 'Title' => $options['title'], 'Sound' => $options['sound'], 'Action' => $options['action'], 'Data' => Serialize::jsonObject($options['data']), 'Apn' => Serialize::jsonObject($options['apn']), 'Gcm' => Serialize::jsonObject($options['gcm']), 'Sms' => Serialize::jsonObject($options['sms']), 'FacebookMessenger' => Serialize::jsonObject($options['facebookMessenger']), 'Fcm' => Serialize::jsonObject($options['fcm']), 'Segment' => Serialize::map($options['segment'], function ($e) {
            return $e;
        }), 'Alexa' => Serialize::jsonObject($options['alexa']), 'ToBinding' => Serialize::map($options['toBinding'], function ($e) {
            return $e;
        }), 'DeliveryCallbackUrl' => $options['deliveryCallbackUrl'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new NotificationInstance($this->version, $payload, $this->solution['serviceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Notify.V1.NotificationList]';
    }
}