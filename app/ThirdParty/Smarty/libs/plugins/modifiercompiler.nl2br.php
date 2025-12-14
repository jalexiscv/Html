<?php
function smarty_modifiercompiler_nl2br($params)
{
    return 'nl2br((string) ' . $params[0] . ', (bool) ' . ($params[1] ?? true) . ')';
}