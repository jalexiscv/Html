<?php

class Smarty_Internal_Method_CompileAllTemplates
{
    public $objMap = 1;

    public function compileAllTemplates(Smarty $smarty, $extension = '.tpl', $force_compile = false, $time_limit = 0, $max_errors = null)
    {
        return $this->compileAll($smarty, $extension, $force_compile, $time_limit, $max_errors);
    }

    protected function compileAll(Smarty $smarty, $extension, $force_compile, $time_limit, $max_errors, $isConfig = false)
    {
        if (function_exists('set_time_limit')) {
            @set_time_limit($time_limit);
        }
        $_count = 0;
        $_error_count = 0;
        $sourceDir = $isConfig ? $smarty->getConfigDir() : $smarty->getTemplateDir();
        foreach ($sourceDir as $_dir) {
            $_dir_1 = new RecursiveDirectoryIterator($_dir, defined('FilesystemIterator::FOLLOW_SYMLINKS') ? FilesystemIterator::FOLLOW_SYMLINKS : 0);
            $_dir_2 = new RecursiveIteratorIterator($_dir_1);
            foreach ($_dir_2 as $_fileinfo) {
                $_file = $_fileinfo->getFilename();
                if (substr(basename($_fileinfo->getPathname()), 0, 1) === '.' || strpos($_file, '.svn') !== false) {
                    continue;
                }
                if (substr_compare($_file, $extension, -strlen($extension)) !== 0) {
                    continue;
                }
                if ($_fileinfo->getPath() !== substr($_dir, 0, -1)) {
                    $_file = substr($_fileinfo->getPath(), strlen($_dir)) . DIRECTORY_SEPARATOR . $_file;
                }
                echo "\n<br>", $_dir, '---', $_file;
                flush();
                $_start_time = microtime(true);
                $_smarty = clone $smarty;
                $_smarty->_cache = array();
                $_smarty->ext = new Smarty_Internal_Extension_Handler();
                $_smarty->ext->objType = $_smarty->_objType;
                $_smarty->force_compile = $force_compile;
                try {
                    $_tpl = new $smarty->template_class($_file, $_smarty);
                    $_tpl->caching = Smarty::CACHING_OFF;
                    $_tpl->source = $isConfig ? Smarty_Template_Config::load($_tpl) : Smarty_Template_Source::load($_tpl);
                    if ($_tpl->mustCompile()) {
                        $_tpl->compileTemplateSource();
                        $_count++;
                        echo ' compiled in  ', microtime(true) - $_start_time, ' seconds';
                        flush();
                    } else {
                        echo ' is up to date';
                        flush();
                    }
                } catch (Exception $e) {
                    echo "\n<br>        ------>Error: ", $e->getMessage(), "<br><br>\n";
                    $_error_count++;
                }
                unset($_tpl);
                $_smarty->_clearTemplateCache();
                if ($max_errors !== null && $_error_count === $max_errors) {
                    echo "\n<br><br>too many errors\n";
                    exit(1);
                }
            }
        }
        echo "\n<br>";
        return $_count;
    }
}