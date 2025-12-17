<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Form;

/**
 * Componente Radio.
 * Wrapper de Check con type=radio.
 */
class Radio extends Check
{
    public function __construct(array $options = [])
    {
        $options['type'] = 'radio';
        parent::__construct($options);
    }
}
