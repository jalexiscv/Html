<?php

namespace Twilio\Rest\Preview\Understand\Assistant;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class StyleSheetOptions
{
    public static function update(array $styleSheet = Values::ARRAY_NONE): UpdateStyleSheetOptions
    {
        return new UpdateStyleSheetOptions($styleSheet);
    }
}

class UpdateStyleSheetOptions extends Options
{
    public function __construct(array $styleSheet = Values::ARRAY_NONE)
    {
        $this->options['styleSheet'] = $styleSheet;
    }

    public function setStyleSheet(array $styleSheet): self
    {
        $this->options['styleSheet'] = $styleSheet;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.Understand.UpdateStyleSheetOptions ' . $options . ']';
    }
}