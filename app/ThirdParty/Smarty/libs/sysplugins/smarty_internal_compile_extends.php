<?php

class Smarty_Internal_Compile_Extends extends Smarty_Internal_Compile_Shared_Inheritance
{
    public $required_attributes = array('file');
    public $optional_attributes = array('extends_resource');
    public $shorttag_order = array('file');

    public function compile($args, Smarty_Internal_TemplateCompilerBase $compiler)
    {
        $_attr = $this->getAttributes($compiler, $args);
        if ($_attr['nocache'] === true) {
            $compiler->trigger_template_error('nocache option not allowed', $compiler->parser->lex->line - 1);
        }
        if (strpos($_attr['file'], '$_tmp') !== false) {
            $compiler->trigger_template_error('illegal value for file attribute', $compiler->parser->lex->line - 1);
        }
        $this->registerInit($compiler, true);
        $file = trim($_attr['file'], '\'"');
        if (strlen($file) > 8 && substr($file, 0, 8) === 'extends:') {
            $files = array_reverse(explode('|', substr($file, 8)));
            $i = 0;
            foreach ($files as $file) {
                if ($file[0] === '"') {
                    $file = trim($file, '".');
                } else {
                    $file = "'{$file}'";
                }
                $i++;
                if ($i === count($files) && isset($_attr['extends_resource'])) {
                    $this->compileEndChild($compiler);
                }
                $this->compileInclude($compiler, $file);
            }
            if (!isset($_attr['extends_resource'])) {
                $this->compileEndChild($compiler);
            }
        } else {
            $this->compileEndChild($compiler, $_attr['file']);
        }
        $compiler->has_code = false;
        return '';
    }

    private function compileEndChild(Smarty_Internal_TemplateCompilerBase $compiler, $template = null)
    {
        $inlineUids = '';
        if (isset($template) && $compiler->smarty->merge_compiled_includes) {
            $code = $compiler->compileTag('include', array($template, array('scope' => 'parent')));
            if (preg_match('/([,][\s]*[\'][a-z0-9]+[\'][,][\s]*[\']content.*[\'])[)]/', $code, $match)) {
                $inlineUids = $match[1];
            }
        }
        $compiler->parser->template_postfix[] = new Smarty_Internal_ParseTree_Tag($compiler->parser, '<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl' . (isset($template) ? ", {$template}{$inlineUids}" : '') . ");\n?>");
    }

    private function compileInclude(Smarty_Internal_TemplateCompilerBase $compiler, $template)
    {
        $compiler->parser->template_postfix[] = new Smarty_Internal_ParseTree_Tag($compiler->parser, $compiler->compileTag('include', array($template, array('scope' => 'parent'))));
    }

    public static function extendsSourceArrayCode(Smarty_Internal_Template $template)
    {
        $resources = array();
        foreach ($template->source->components as $source) {
            $resources[] = $source->resource;
        }
        return $template->smarty->left_delimiter . 'extends file=\'extends:' . join('|', $resources) . '\' extends_resource=true' . $template->smarty->right_delimiter;
    }
}