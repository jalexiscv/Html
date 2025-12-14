<?php
declare(strict_types=1);

namespace Kint\Zval;

use Kint\Kint;

class StreamValue extends ResourceValue
{
    public $stream_meta;

    public function __construct(array $meta = null)
    {
        parent::__construct();
        $this->stream_meta = $meta;
    }

    public function getValueShort(): ?string
    {
        if (empty($this->stream_meta['uri'])) {
            return null;
        }
        $uri = $this->stream_meta['uri'];
        if (\stream_is_local($uri)) {
            return Kint::shortenPath($uri);
        }
        return $uri;
    }
}