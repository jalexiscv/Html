<?php

class Smarty_Internal_Method_GetTags
{
    public $objMap = 3;

    public function getTags(Smarty_Internal_TemplateBase $obj, $template = null)
    {
        $smarty = $obj->_getSmartyObj();
        if ($obj->_isTplObj() && !isset($template)) {
            $tpl = clone $obj;
        } elseif (isset($template) && $template->_isTplObj()) {
            $tpl = clone $template;
        } elseif (isset($template) && is_string($template)) {
            $tpl = new $smarty->template_class($template, $smarty);
            if (!$tpl->source->exists) {
                throw new SmartyException("Unable to load template {$tpl->source->type} '{$tpl->source->name}'");
            }
        }
        if (isset($tpl)) {
            $tpl->smarty = clone $tpl->smarty;
            $tpl->smarty->_cache['get_used_tags'] = true;
            $tpl->_cache['used_tags'] = array();
            $tpl->smarty->merge_compiled_includes = false;
            $tpl->smarty->disableSecurity();
            $tpl->caching = Smarty::CACHING_OFF;
            $tpl->loadCompiler();
            $tpl->compiler->compileTemplate($tpl);
            return $tpl->_cache['used_tags'];
        }
        throw new SmartyException('Missing template specification');
    }
}