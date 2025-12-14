<?php
declare(strict_types=1);

namespace drupol\htmltag\benchmarks;

use drupol\htmltag\Attribute\AttributeFactory;
use drupol\htmltag\Attribute\AttributeFactoryInterface;
use drupol\htmltag\Attributes\Attributes;
use PhpBench\Benchmark\Metadata\Annotations\BeforeMethods;

class AttributesBench extends AbstractBench
{
    private $attributeFactory;

    public function benchAttributesRender()
    {
        $attributes = new Attributes($this->attributeFactory, $this->getAttributes());
        $attributes->render();
    }

    public function initAttributesRender()
    {
        $this->attributeFactory = new AttributeFactory();
    }
}