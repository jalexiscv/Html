<?php

namespace drupol\htmltag\Tag;

use function sprintf;

final class Comment extends AbstractTag
{
    public function render()
    {
        return sprintf('<!--%s-->', $this->renderContent());
    }
}