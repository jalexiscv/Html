<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ConnectAppOptions
{
    public static function update(string $authorizeRedirectUrl = Values::NONE, string $companyName = Values::NONE, string $deauthorizeCallbackMethod = Values::NONE, string $deauthorizeCallbackUrl = Values::NONE, string $description = Values::NONE, string $friendlyName = Values::NONE, string $homepageUrl = Values::NONE, array $permissions = Values::ARRAY_NONE): UpdateConnectAppOptions
    {
        return new UpdateConnectAppOptions($authorizeRedirectUrl, $companyName, $deauthorizeCallbackMethod, $deauthorizeCallbackUrl, $description, $friendlyName, $homepageUrl, $permissions);
    }
}

class UpdateConnectAppOptions extends Options
{
    public function __construct(string $authorizeRedirectUrl = Values::NONE, string $companyName = Values::NONE, string $deauthorizeCallbackMethod = Values::NONE, string $deauthorizeCallbackUrl = Values::NONE, string $description = Values::NONE, string $friendlyName = Values::NONE, string $homepageUrl = Values::NONE, array $permissions = Values::ARRAY_NONE)
    {
        $this->options['authorizeRedirectUrl'] = $authorizeRedirectUrl;
        $this->options['companyName'] = $companyName;
        $this->options['deauthorizeCallbackMethod'] = $deauthorizeCallbackMethod;
        $this->options['deauthorizeCallbackUrl'] = $deauthorizeCallbackUrl;
        $this->options['description'] = $description;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['homepageUrl'] = $homepageUrl;
        $this->options['permissions'] = $permissions;
    }

    public function setAuthorizeRedirectUrl(string $authorizeRedirectUrl): self
    {
        $this->options['authorizeRedirectUrl'] = $authorizeRedirectUrl;
        return $this;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->options['companyName'] = $companyName;
        return $this;
    }

    public function setDeauthorizeCallbackMethod(string $deauthorizeCallbackMethod): self
    {
        $this->options['deauthorizeCallbackMethod'] = $deauthorizeCallbackMethod;
        return $this;
    }

    public function setDeauthorizeCallbackUrl(string $deauthorizeCallbackUrl): self
    {
        $this->options['deauthorizeCallbackUrl'] = $deauthorizeCallbackUrl;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->options['description'] = $description;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setHomepageUrl(string $homepageUrl): self
    {
        $this->options['homepageUrl'] = $homepageUrl;
        return $this;
    }

    public function setPermissions(array $permissions): self
    {
        $this->options['permissions'] = $permissions;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.UpdateConnectAppOptions ' . $options . ']';
    }
}