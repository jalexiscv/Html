<?php

class Smarty_Internal_Resource_Php extends Smarty_Internal_Resource_File
{
    public $uncompiled = true;
    public $hasCompiledHandler = true;
    protected $short_open_tag;

    public function __construct()
    {
        $this->short_open_tag = function_exists('ini_get') ? ini_get('short_open_tag') : 1;
    }

    public function getContent(Smarty_Template_Source $source)
    {
        if ($source->exists) {
            return '';
        }
        throw new SmartyException("Unable to read template {$source->type} '{$source->name}'");
    }

    public function populateCompiledFilepath(Smarty_Template_Compiled $compiled, Smarty_Internal_Template $_template)
    {
        $compiled->filepath = $_template->source->filepath;
        $compiled->timestamp = $_template->source->timestamp;
        $compiled->exists = $_template->source->exists;
        $compiled->file_dependency[$_template->source->uid] = array($compiled->filepath, $compiled->timestamp, $_template->source->type,);
    }

    public function renderUncompiled(Smarty_Template_Source $source, Smarty_Internal_Template $_template)
    {
        if (!$source->smarty->allow_php_templates) {
            throw new SmartyException('PHP templates are disabled');
        }
        if (!$source->exists) {
            throw new SmartyException("Unable to load template '{$source->type}:{$source->name}'" . ($_template->_isSubTpl() ? " in '{$_template->parent->template_resource}'" : ''));
        }
        extract($_template->getTemplateVars());
        if (function_exists('ini_set')) {
            ini_set('short_open_tag', '1');
        }
        $_smarty_template = $_template;
        include $source->filepath;
        if (function_exists('ini_set')) {
            ini_set('short_open_tag', $this->short_open_tag);
        }
    }
}