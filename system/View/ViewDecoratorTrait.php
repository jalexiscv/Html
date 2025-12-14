<?php

namespace Higgs\View;

use Higgs\View\Exceptions\ViewException;

trait ViewDecoratorTrait
{
    protected function decorateOutput(string $html): string
    {
        $decorators = \config('View')->decorators;
        foreach ($decorators as $decorator) {
            if (!is_subclass_of($decorator, ViewDecoratorInterface::class)) {
                throw ViewException::forInvalidDecorator($decorator);
            }
            $html = $decorator::decorate($html);
        }
        return $html;
    }
}