<?php
function smarty_modifier_explode($separator, $string, ?int $limit = null)
{
    return explode($separator, $string ?? '', $limit ?? PHP_INT_MAX);
}