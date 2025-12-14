<?php
function smarty_modifier_replace($string, $search, $replace)
{
    static $is_loaded = false;
    if (Smarty::$_MBSTRING) {
        if (!$is_loaded) {
            if (!is_callable('smarty_mb_str_replace')) {
                include_once SMARTY_PLUGINS_DIR . 'shared.mb_str_replace.php';
            }
            $is_loaded = true;
        }
        return smarty_mb_str_replace($search, $replace, $string);
    }
    return str_replace($search, $replace, $string);
}