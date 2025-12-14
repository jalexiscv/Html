<?php
function smarty_modifiercompiler_cat($params)
{
    return '(' . implode(').(', $params) . ')';
}