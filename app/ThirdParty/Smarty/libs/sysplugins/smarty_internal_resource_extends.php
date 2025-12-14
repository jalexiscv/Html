<?php

class Smarty_Internal_Resource_Extends extends Smarty_Resource
{
    public $mbstring_overload = 0;

    public function populate(Smarty_Template_Source $source, Smarty_Internal_Template $_template = null)
    {
        $uid = '';
        $sources = array();
        $components = explode('|', $source->name);
        $smarty = &$source->smarty;
        $exists = true;
        foreach ($components as $component) {
            $_s = Smarty_Template_Source::load(null, $smarty, $component);
            if ($_s->type === 'php') {
                throw new SmartyException("Resource type {$_s->type} cannot be used with the extends resource type");
            }
            $sources[$_s->uid] = $_s;
            $uid .= $_s->filepath;
            if ($_template) {
                $exists = $exists && $_s->exists;
            }
        }
        $source->components = $sources;
        $source->filepath = $_s->filepath;
        $source->uid = sha1($uid . $source->smarty->_joined_template_dir);
        $source->exists = $exists;
        if ($_template) {
            $source->timestamp = $_s->timestamp;
        }
    }

    public function populateTimestamp(Smarty_Template_Source $source)
    {
        $source->exists = true;
        foreach ($source->components as $_s) {
            $source->exists = $source->exists && $_s->exists;
        }
        $source->timestamp = $source->exists ? $_s->getTimeStamp() : false;
    }

    public function getContent(Smarty_Template_Source $source)
    {
        if (!$source->exists) {
            throw new SmartyException("Unable to load template '{$source->type}:{$source->name}'");
        }
        $_components = array_reverse($source->components);
        $_content = '';
        foreach ($_components as $_s) {
            $_content .= $_s->getContent();
        }
        return $_content;
    }

    public function getBasename(Smarty_Template_Source $source)
    {
        return str_replace(':', '.', basename($source->filepath));
    }

    public function checkTimestamps()
    {
        return false;
    }
}