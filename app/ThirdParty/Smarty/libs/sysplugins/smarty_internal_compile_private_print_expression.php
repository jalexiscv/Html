<?php

class Smarty_Internal_Compile_Private_Print_Expression extends Smarty_Internal_CompileBase
{
    public $optional_attributes = array('assign');
    public $option_flags = array('nocache', 'nofilter');

    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler, $parameter)
    {
        $_attr = $this->getAttributes($compiler, $args);
        $output = $parameter['value'];
        if (!empty($parameter['modifierlist'])) {
            $output = $compiler->compileTag('private_modifier', array(), array('modifierlist' => $parameter['modifierlist'], 'value' => $output));
        }
        if (isset($_attr['assign'])) {
            return "<?php \$_smarty_tpl->assign({$_attr['assign']},{$output});?>";
        } else {
            if (!$_attr['nofilter']) {
                if (!empty($compiler->smarty->default_modifiers)) {
                    if (empty($compiler->default_modifier_list)) {
                        $modifierlist = array();
                        foreach ($compiler->smarty->default_modifiers as $key => $single_default_modifier) {
                            preg_match_all('/(\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'|"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"|:|[^:]+)/', $single_default_modifier, $mod_array);
                            for ($i = 0, $count = count($mod_array[0]); $i < $count; $i++) {
                                if ($mod_array[0][$i] !== ':') {
                                    $modifierlist[$key][] = $mod_array[0][$i];
                                }
                            }
                        }
                        $compiler->default_modifier_list = $modifierlist;
                    }
                    $output = $compiler->compileTag('private_modifier', array(), array('modifierlist' => $compiler->default_modifier_list, 'value' => $output));
                }
                if ($compiler->template->smarty->escape_html) {
                    $output = "htmlspecialchars((string) {$output}, ENT_QUOTES, '" . addslashes(Smarty::$_CHARSET) . "')";
                }
                if (!empty($compiler->template->smarty->registered_filters[Smarty::FILTER_VARIABLE])) {
                    foreach ($compiler->template->smarty->registered_filters[Smarty::FILTER_VARIABLE] as $key => $function) {
                        if (!is_array($function)) {
                            $output = "{$function}({$output},\$_smarty_tpl)";
                        } elseif (is_object($function[0])) {
                            $output = "\$_smarty_tpl->smarty->registered_filters[Smarty::FILTER_VARIABLE]['{$key}'][0]->{$function[1]}({$output},\$_smarty_tpl)";
                        } else {
                            $output = "{$function[0]}::{$function[1]}({$output},\$_smarty_tpl)";
                        }
                    }
                }
                if (isset($compiler->smarty->autoload_filters[Smarty::FILTER_VARIABLE])) {
                    foreach ((array)$compiler->template->smarty->autoload_filters[Smarty::FILTER_VARIABLE] as $name) {
                        $result = $this->compile_variable_filter($compiler, $name, $output);
                        if ($result !== false) {
                            $output = $result;
                        } else {
                            throw new SmartyException("Unable to load variable filter '{$name}'");
                        }
                    }
                }
                foreach ($compiler->variable_filters as $filter) {
                    if (count($filter) === 1 && ($result = $this->compile_variable_filter($compiler, $filter[0], $output)) !== false) {
                        $output = $result;
                    } else {
                        $output = $compiler->compileTag('private_modifier', array(), array('modifierlist' => array($filter), 'value' => $output));
                    }
                }
            }
            $output = "<?php echo {$output};?>\n";
        }
        return $output;
    }

    private function compile_variable_filter(Smarty_Internal_TemplateCompilerBase $compiler, $name, $output)
    {
        $function = $compiler->getPlugin($name, 'variablefilter');
        if ($function) {
            return "{$function}({$output},\$_smarty_tpl)";
        } else {
            return false;
        }
    }
}