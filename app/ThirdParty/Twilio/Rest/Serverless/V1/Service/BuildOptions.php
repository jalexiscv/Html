<?php

namespace Twilio\Rest\Serverless\V1\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class BuildOptions
{
    public static function create(array $assetVersions = Values::ARRAY_NONE, array $functionVersions = Values::ARRAY_NONE, string $dependencies = Values::NONE): CreateBuildOptions
    {
        return new CreateBuildOptions($assetVersions, $functionVersions, $dependencies);
    }
}

class CreateBuildOptions extends Options
{
    public function __construct(array $assetVersions = Values::ARRAY_NONE, array $functionVersions = Values::ARRAY_NONE, string $dependencies = Values::NONE)
    {
        $this->options['assetVersions'] = $assetVersions;
        $this->options['functionVersions'] = $functionVersions;
        $this->options['dependencies'] = $dependencies;
    }

    public function setAssetVersions(array $assetVersions): self
    {
        $this->options['assetVersions'] = $assetVersions;
        return $this;
    }

    public function setFunctionVersions(array $functionVersions): self
    {
        $this->options['functionVersions'] = $functionVersions;
        return $this;
    }

    public function setDependencies(string $dependencies): self
    {
        $this->options['dependencies'] = $dependencies;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Serverless.V1.CreateBuildOptions ' . $options . ']';
    }
}