<?php

declare(strict_types=1);

namespace Higgs\Html\Tag;

/**
 * Clase Comment.
 */
final class Comment extends AbstractTag
{
    public function render(): string
    {
        return sprintf('<!--%s-->', $this->renderContent());
    }
}
