<?php

namespace drupol\htmltag;
interface PreprocessableInterface
{
    public function preprocess(array $values, array $context = []);
}