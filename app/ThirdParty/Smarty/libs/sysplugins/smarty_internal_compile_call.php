<?php

class Smarty_Internal_Compile_Call extends Smarty_Internal_CompileBase
{
    public $required_attributes = array('name');
    public $shorttag_order = array('name');
    public $optional_attributes = array('_any');

    public function compile($args, $compiler)
    {
        $_attr = $this->getAttributes($compiler, $args);
        if (isset($_attr['assign'])) {
            $_assign = $_attr['assign'];
        }
        $_name = $_attr['name'];
        unset($_attr['name'], $_attr['assign'], $_attr['nocache']);
        if (!$compiler->template->caching || $compiler->nocache || $compiler->tag_nocache) {
            $_nocache = 'true';
        } else {
            $_nocache = 'false';
        }
        $_paramsArray = array();
        foreach ($_attr as $_key => $_value) {
            if (is_int($_key)) {
                $_paramsArray[] = "$_key=>$_value";
            } else {
                $_paramsArray[] = "'$_key'=>$_value";
            }
        }
        $_params = 'array(' . implode(',', $_paramsArray) . ')';
        if (isset($_assign)) {
            $_output = "<?php ob_start();\n\$_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction(\$_smarty_tpl, {$_name}, {$_params}, {$_nocache});\n\$_smarty_tpl->assign({$_assign}, ob_get_clean());?>\n";
        } else {
            $_output = "<?php \$_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction(\$_smarty_tpl, {$_name}, {$_params}, {$_nocache});?>\n";
        }
        return $_output;
    }
}