<?php

abstract class Smarty_Resource_Uncompiled extends Smarty_Resource
{
    public $uncompiled = true;
    public $hasCompiledHandler = true;

    public function populateCompiledFilepath(Smarty_Template_Compiled $compiled, Smarty_Internal_Template $_template)
    {
        $compiled->filepath = $_template->source->filepath;
        $compiled->timestamp = $_template->source->timestamp;
        $compiled->exists = $_template->source->exists;
        if ($_template->smarty->merge_compiled_includes || $_template->source->handler->checkTimestamps()) {
            $compiled->file_dependency[$_template->source->uid] = array($compiled->filepath, $compiled->timestamp, $_template->source->type,);
        }
    }
}