<?php

namespace Twilio\Rest\Fax\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Fax\V1\Fax\FaxMediaList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class FaxInstance extends InstanceResource
{
    protected $_media;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'from' => Values::array_get($payload, 'from'), 'to' => Values::array_get($payload, 'to'), 'quality' => Values::array_get($payload, 'quality'), 'mediaSid' => Values::array_get($payload, 'media_sid'), 'mediaUrl' => Values::array_get($payload, 'media_url'), 'numPages' => Values::array_get($payload, 'num_pages'), 'duration' => Values::array_get($payload, 'duration'), 'status' => Values::array_get($payload, 'status'), 'direction' => Values::array_get($payload, 'direction'), 'apiVersion' => Values::array_get($payload, 'api_version'), 'price' => Values::array_get($payload, 'price'), 'priceUnit' => Values::array_get($payload, 'price_unit'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'links' => Values::array_get($payload, 'links'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): FaxContext
    {
        if (!$this->context) {
            $this->context = new FaxContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): FaxInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): FaxInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getMedia(): FaxMediaList
    {
        return $this->proxy()->media;
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown property: ' . $name);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Fax.V1.FaxInstance ' . implode(' ', $context) . ']';
    }
}