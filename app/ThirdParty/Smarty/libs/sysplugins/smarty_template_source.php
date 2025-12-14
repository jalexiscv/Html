<?php

class Smarty_Template_Source
{
    public $uid = null;
    public $resource = null;
    public $type = null;
    public $name = null;
    public $filepath = null;
    public $timestamp = null;
    public $exists = false;
    public $basename = null;
    public $components = null;
    public $handler = null;
    public $smarty = null;
    public $isConfig = false;
    public $content = null;
    public $compiler_class = 'Smarty_Internal_SmartyTemplateCompiler';
    public $template_lexer_class = 'Smarty_Internal_Templatelexer';
    public $template_parser_class = 'Smarty_Internal_Templateparser';

    public function __construct(Smarty $smarty, $resource, $type, $name)
    {
        $this->handler = isset($smarty->_cache['resource_handlers'][$type]) ? $smarty->_cache['resource_handlers'][$type] : Smarty_Resource::load($smarty, $type);
        $this->smarty = $smarty;
        $this->resource = $resource;
        $this->type = $type;
        $this->name = $name;
    }

    public static function load(Smarty_Internal_Template $_template = null, Smarty $smarty = null, $template_resource = null)
    {
        if ($_template) {
            $smarty = $_template->smarty;
            $template_resource = $_template->template_resource;
        }
        if (empty($template_resource)) {
            throw new SmartyException('Source: Missing  name');
        }
        if (preg_match('/^([A-Za-z0-9_\-]{2,})[:]([\s\S]*)$/', $template_resource, $match)) {
            $type = $match[1];
            $name = $match[2];
        } else {
            $type = $smarty->default_resource_type;
            $name = $template_resource;
        }
        $source = new Smarty_Template_Source($smarty, $template_resource, $type, $name);
        $source->handler->populate($source, $_template);
        if (!$source->exists && isset($_template->smarty->default_template_handler_func)) {
            Smarty_Internal_Method_RegisterDefaultTemplateHandler::_getDefaultTemplate($source);
            $source->handler->populate($source, $_template);
        }
        return $source;
    }

    public function getTimeStamp()
    {
        if (!isset($this->timestamp)) {
            $this->handler->populateTimestamp($this);
        }
        return $this->timestamp;
    }

    public function getContent()
    {
        return isset($this->content) ? $this->content : $this->handler->getContent($this);
    }
}