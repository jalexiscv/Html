<?php
function smarty_modifiercompiler_strip($params)
{
    if (!isset($params[1])) {
        $params[1] = "' '";
    }
    return "preg_replace('!\s+!" . Smarty::$_UTF8_MODIFIER . "', {$params[1]},{$params[0]})";
}