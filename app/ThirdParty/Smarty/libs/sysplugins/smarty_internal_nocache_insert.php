<?php

class Smarty_Internal_Nocache_Insert
{
    public static function compile($_function, $_attr, $_template, $_script, $_assign = null)
    {
        $_output = '<?php ';
        if ($_script !== 'null') {
            $_output .= "require_once '{$_script}';";
        }
        if (isset($_assign)) {
            $_output .= "\$_smarty_tpl->assign('{$_assign}' , {$_function} (" . var_export($_attr, true) . ',\$_smarty_tpl), true);?>';
        } else {
            $_output .= "echo {$_function}(" . var_export($_attr, true) . ',$_smarty_tpl);?>';
        }
        $_tpl = $_template;
        while ($_tpl->_isSubTpl()) {
            $_tpl = $_tpl->parent;
        }
        return "/*%%SmartyNocache:{$_tpl->compiled->nocache_hash}%%*/{$_output}/*/%%SmartyNocache:{$_tpl->compiled->nocache_hash}%%*/";
    }
}