<?php

class Smarty_Template_Config extends Smarty_Template_Source
{
    public $config_sections = null;
    public $scope = 0;
    public $isConfig = true;
    public $compiler_class = 'Smarty_Internal_Config_File_Compiler';
    public $template_lexer_class = 'Smarty_Internal_Configfilelexer';
    public $template_parser_class = 'Smarty_Internal_Configfileparser';

    public static function load(Smarty_Internal_Template $_template = null, Smarty $smarty = null, $template_resource = null)
    {
        static $_incompatible_resources = array('extends' => true, 'php' => true);
        if ($_template) {
            $smarty = $_template->smarty;
            $template_resource = $_template->template_resource;
        }
        if (empty($template_resource)) {
            throw new SmartyException('Source: Missing  name');
        }
        list($name, $type) = Smarty_Resource::parseResourceName($template_resource, $smarty->default_config_type);
        if (isset($_incompatible_resources[$type])) {
            throw new SmartyException("Unable to use resource '{$type}' for config");
        }
        $source = new Smarty_Template_Config($smarty, $template_resource, $type, $name);
        $source->handler->populate($source, $_template);
        if (!$source->exists && isset($smarty->default_config_handler_func)) {
            Smarty_Internal_Method_RegisterDefaultTemplateHandler::_getDefaultTemplate($source);
            $source->handler->populate($source, $_template);
        }
        return $source;
    }
}