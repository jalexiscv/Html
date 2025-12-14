<?php
const SMARTY_HELPER_FUNCTIONS_LOADED = true;
function smarty_ucfirst_ascii($string): string
{
    return smarty_strtoupper_ascii(substr($string, 0, 1)) . substr($string, 1);
}

function smarty_strtolower_ascii($string): string
{
    return strtr($string, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz');
}

function smarty_strtoupper_ascii($string): string
{
    return strtr($string, 'abcdefghijklmnopqrstuvwxyz', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
}