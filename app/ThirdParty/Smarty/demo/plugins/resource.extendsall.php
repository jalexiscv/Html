<?php

class Smarty_Resource_Extendsall extends Smarty_Internal_Resource_Extends
{
    public function populate(Smarty_Template_Source $source, Smarty_Internal_Template $_template = null)
    {
        $uid = '';
        $sources = array();
        $timestamp = 0;
        foreach ($source->smarty->getTemplateDir() as $key => $directory) {
            try {
                $s = Smarty_Resource::source(null, $source->smarty, 'file:' . '[' . $key . ']' . $source->name);
                if (!$s->exists) {
                    continue;
                }
                $sources[$s->uid] = $s;
                $uid .= $s->filepath;
                $timestamp = $s->timestamp > $timestamp ? $s->timestamp : $timestamp;
            } catch (SmartyException $e) {
            }
        }
        if (!$sources) {
            $source->exists = false;
            return;
        }
        $sources = array_reverse($sources, true);
        reset($sources);
        $s = current($sources);
        $source->components = $sources;
        $source->filepath = $s->filepath;
        $source->uid = sha1($uid . $source->smarty->_joined_template_dir);
        $source->exists = true;
        $source->timestamp = $timestamp;
    }

    public function checkTimestamps()
    {
        return false;
    }
}