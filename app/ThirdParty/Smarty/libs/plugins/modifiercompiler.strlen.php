<?php
function smarty_modifiercompiler_strlen($params)
{
    return 'strlen((string) ' . $params[0] . ')';
}