<?php
function smarty_modifiercompiler_round($params)
{
    return 'round((float) ' . $params[0] . ', (int) ' . ($params[1] ?? 0) . ', (int) ' . ($params[2] ?? PHP_ROUND_HALF_UP) . ')';
}