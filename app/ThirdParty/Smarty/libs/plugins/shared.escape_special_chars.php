<?php
function smarty_function_escape_special_chars($string)
{
    if (!is_array($string)) {
        $string = htmlspecialchars($string, ENT_COMPAT, Smarty::$_CHARSET, false);
    }
    return $string;
}