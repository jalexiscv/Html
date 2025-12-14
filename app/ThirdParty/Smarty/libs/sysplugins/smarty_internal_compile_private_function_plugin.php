<?php

class Smarty_Internal_Compile_Private_Function_Plugin extends Smarty_Internal_CompileBase
{
    public $required_attributes = array();
    public $optional_attributes = array('_any');

    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler, $parameter, $tag, $function)
    {
        $_attr = $this->getAttributes($compiler, $args);
        unset($_attr['nocache']);
        $_paramsArray = array();
        foreach ($_attr as $_key => $_value) {
            if (is_int($_key)) {
                $_paramsArray[] = "$_key=>$_value";
            } else {
                $_paramsArray[] = "'$_key'=>$_value";
            }
        }
        $_params = 'array(' . implode(',', $_paramsArray) . ')';
        $output = "{$function}({$_params},\$_smarty_tpl)";
        if (!empty($parameter['modifierlist'])) {
            $output = $compiler->compileTag('private_modifier', array(), array('modifierlist' => $parameter['modifierlist'], 'value' => $output));
        }
        $output = "<?php echo {$output};?>\n";
        return $output;
    }
}