<?php
function smarty_modifier_count($arrayOrObject, $mode = 0)
{
    if ($arrayOrObject instanceof Countable || is_array($arrayOrObject)) {
        return count($arrayOrObject, (int)$mode);
    } elseif ($arrayOrObject === null) {
        return 0;
    }
    return 1;
}