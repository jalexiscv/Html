<?php
function smarty_modifiercompiler_wordwrap($params, Smarty_Internal_TemplateCompilerBase $compiler)
{
    if (!isset($params[1])) {
        $params[1] = 80;
    }
    if (!isset($params[2])) {
        $params[2] = '"\n"';
    }
    if (!isset($params[3])) {
        $params[3] = 'false';
    }
    $function = 'wordwrap';
    if (Smarty::$_MBSTRING) {
        $function = $compiler->getPlugin('mb_wordwrap', 'modifier');
    }
    return $function . '(' . $params[0] . ',' . $params[1] . ',' . $params[2] . ',' . $params[3] . ')';
}