<?php
function smarty_modifiercompiler_str_repeat($params)
{
    return 'str_repeat((string) ' . $params[0] . ', (int) ' . $params[1] . ')';
}