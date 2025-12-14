<?php

class Smarty_Internal_Method_CompileAllConfig extends Smarty_Internal_Method_CompileAllTemplates
{
    public function compileAllConfig(Smarty $smarty, $extension = '.conf', $force_compile = false, $time_limit = 0, $max_errors = null)
    {
        return $this->compileAll($smarty, $extension, $force_compile, $time_limit, $max_errors, true);
    }
}