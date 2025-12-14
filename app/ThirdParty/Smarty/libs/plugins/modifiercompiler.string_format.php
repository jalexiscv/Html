<?php
function smarty_modifiercompiler_string_format($params)
{
    return 'sprintf(' . $params[1] . ',' . $params[0] . ')';
}