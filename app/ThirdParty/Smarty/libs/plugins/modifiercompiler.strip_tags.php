<?php
function smarty_modifiercompiler_strip_tags($params)
{
    if (!isset($params[1]) || $params[1] === true || trim($params[1], '"') === 'true') {
        return "preg_replace('!<[^>]*?>!', ' ', {$params[0]} ?: '')";
    } else {
        return 'strip_tags((string) ' . $params[0] . ')';
    }
}