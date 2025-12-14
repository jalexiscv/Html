<?php
declare(strict_types=1);

namespace drupol\htmltag\benchmarks;

use drupol\htmltag\Attribute\Attribute;

class AttributeBench extends AbstractBench
{
    public function benchAttributeRender()
    {
        foreach ($this->getAttributes() as $name => $value) {
            $attribute = new Attribute($name, $value);
            $attribute->render();
        }
    }
}