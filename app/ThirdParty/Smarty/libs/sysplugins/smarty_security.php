<?php

#[\AllowDynamicProperties] class Smarty_Security
{
    public $secure_dir = array();
    public $trusted_dir = array();
    public $trusted_uri = array();
    public $trusted_constants = array();
    public $static_classes = array();
    public $trusted_static_methods = array();
    public $trusted_static_properties = array();
    public $php_functions = array('isset', 'empty', 'count', 'sizeof', 'in_array', 'is_array', 'time',);
    public $php_modifiers = array('escape', 'count', 'sizeof', 'nl2br',);
    public $allowed_tags = array();
    public $disabled_tags = array();
    public $allowed_modifiers = array();
    public $disabled_modifiers = array();
    public $disabled_special_smarty_vars = array();
    public $streams = array('file');
    public $allow_constants = true;
    public $allow_super_globals = true;
    public $max_template_nesting = 0;
    protected $_resource_dir = array();
    protected $_template_dir = array();
    protected $_config_dir = array();
    protected $_secure_dir = array();
    protected $_php_resource_dir = null;
    protected $_trusted_dir = null;
    protected $_include_path_status = false;
    protected $_include_dir = array();
    private $_current_template_nesting = 0;

    public function __construct($smarty)
    {
        $this->smarty = $smarty;
    }

    public static function enableSecurity(Smarty $smarty, $security_class)
    {
        if ($security_class instanceof Smarty_Security) {
            $smarty->security_policy = $security_class;
            return $smarty;
        } elseif (is_object($security_class)) {
            throw new SmartyException("Class '" . get_class($security_class) . "' must extend Smarty_Security.");
        }
        if ($security_class === null) {
            $security_class = $smarty->security_class;
        }
        if (!class_exists($security_class)) {
            throw new SmartyException("Security class '$security_class' is not defined");
        } elseif ($security_class !== 'Smarty_Security' && !is_subclass_of($security_class, 'Smarty_Security')) {
            throw new SmartyException("Class '$security_class' must extend Smarty_Security.");
        } else {
            $smarty->security_policy = new $security_class($smarty);
        }
        return $smarty;
    }

    public function isTrustedPhpFunction($function_name, $compiler)
    {
        if (isset($this->php_functions) && (empty($this->php_functions) || in_array($function_name, $this->php_functions))) {
            return true;
        }
        $compiler->trigger_template_error("PHP function '{$function_name}' not allowed by security setting");
        return false;
    }

    public function isTrustedStaticClassAccess($class_name, $params, $compiler)
    {
        if (!isset($params[2])) {
            return $this->isTrustedStaticClass($class_name, $compiler);
        }
        if ($params[2] === 'method') {
            $allowed = $this->trusted_static_methods;
            $name = substr($params[0], 0, strpos($params[0], '('));
        } else {
            $allowed = $this->trusted_static_properties;
            $name = substr($params[0], 1);
        }
        if (isset($allowed)) {
            if (empty($allowed)) {
                return $this->isTrustedStaticClass($class_name, $compiler);
            }
            if (isset($allowed[$class_name]) && (empty($allowed[$class_name]) || in_array($name, $allowed[$class_name]))) {
                return true;
            }
        }
        $compiler->trigger_template_error("access to static class '{$class_name}' {$params[2]} '{$name}' not allowed by security setting");
        return false;
    }

    public function isTrustedStaticClass($class_name, $compiler)
    {
        if (isset($this->static_classes) && (empty($this->static_classes) || in_array($class_name, $this->static_classes))) {
            return true;
        }
        $compiler->trigger_template_error("access to static class '{$class_name}' not allowed by security setting");
        return false;
    }

    public function isTrustedPhpModifier($modifier_name, $compiler)
    {
        if (isset($this->php_modifiers) && (empty($this->php_modifiers) || in_array($modifier_name, $this->php_modifiers))) {
            return true;
        }
        $compiler->trigger_template_error("modifier '{$modifier_name}' not allowed by security setting");
        return false;
    }

    public function isTrustedTag($tag_name, $compiler)
    {
        if (in_array($tag_name, array('assign', 'call', 'private_filter', 'private_block_plugin', 'private_function_plugin', 'private_object_block_function', 'private_object_function', 'private_registered_function', 'private_registered_block', 'private_special_variable', 'private_print_expression', 'private_modifier'))) {
            return true;
        }
        if (empty($this->allowed_tags)) {
            if (empty($this->disabled_tags) || !in_array($tag_name, $this->disabled_tags)) {
                return true;
            } else {
                $compiler->trigger_template_error("tag '{$tag_name}' disabled by security setting", null, true);
            }
        } elseif (in_array($tag_name, $this->allowed_tags) && !in_array($tag_name, $this->disabled_tags)) {
            return true;
        } else {
            $compiler->trigger_template_error("tag '{$tag_name}' not allowed by security setting", null, true);
        }
        return false;
    }

    public function isTrustedSpecialSmartyVar($var_name, $compiler)
    {
        if (!in_array($var_name, $this->disabled_special_smarty_vars)) {
            return true;
        } else {
            $compiler->trigger_template_error("special variable '\$smarty.{$var_name}' not allowed by security setting", null, true);
        }
        return false;
    }

    public function isTrustedModifier($modifier_name, $compiler)
    {
        if (in_array($modifier_name, array('default'))) {
            return true;
        }
        if (empty($this->allowed_modifiers)) {
            if (empty($this->disabled_modifiers) || !in_array($modifier_name, $this->disabled_modifiers)) {
                return true;
            } else {
                $compiler->trigger_template_error("modifier '{$modifier_name}' disabled by security setting", null, true);
            }
        } elseif (in_array($modifier_name, $this->allowed_modifiers) && !in_array($modifier_name, $this->disabled_modifiers)) {
            return true;
        } else {
            $compiler->trigger_template_error("modifier '{$modifier_name}' not allowed by security setting", null, true);
        }
        return false;
    }

    public function isTrustedConstant($const, $compiler)
    {
        if (in_array($const, array('true', 'false', 'null'))) {
            return true;
        }
        if (!empty($this->trusted_constants)) {
            if (!in_array(strtolower($const), $this->trusted_constants)) {
                $compiler->trigger_template_error("Security: access to constant '{$const}' not permitted");
                return false;
            }
            return true;
        }
        if ($this->allow_constants) {
            return true;
        }
        $compiler->trigger_template_error("Security: access to constants not permitted");
        return false;
    }

    public function isTrustedStream($stream_name)
    {
        if (isset($this->streams) && (empty($this->streams) || in_array($stream_name, $this->streams))) {
            return true;
        }
        throw new SmartyException("stream '{$stream_name}' not allowed by security setting");
    }

    public function isTrustedResourceDir($filepath, $isConfig = null)
    {
        if ($this->_include_path_status !== $this->smarty->use_include_path) {
            $_dir = $this->smarty->use_include_path ? $this->smarty->ext->_getIncludePath->getIncludePathDirs($this->smarty) : array();
            if ($this->_include_dir !== $_dir) {
                $this->_updateResourceDir($this->_include_dir, $_dir);
                $this->_include_dir = $_dir;
            }
            $this->_include_path_status = $this->smarty->use_include_path;
        }
        $_dir = $this->smarty->getTemplateDir();
        if ($this->_template_dir !== $_dir) {
            $this->_updateResourceDir($this->_template_dir, $_dir);
            $this->_template_dir = $_dir;
        }
        $_dir = $this->smarty->getConfigDir();
        if ($this->_config_dir !== $_dir) {
            $this->_updateResourceDir($this->_config_dir, $_dir);
            $this->_config_dir = $_dir;
        }
        if ($this->_secure_dir !== $this->secure_dir) {
            $this->secure_dir = (array)$this->secure_dir;
            foreach ($this->secure_dir as $k => $d) {
                $this->secure_dir[$k] = $this->smarty->_realpath($d . DIRECTORY_SEPARATOR, true);
            }
            $this->_updateResourceDir($this->_secure_dir, $this->secure_dir);
            $this->_secure_dir = $this->secure_dir;
        }
        $addPath = $this->_checkDir($filepath, $this->_resource_dir);
        if ($addPath !== false) {
            $this->_resource_dir = array_merge($this->_resource_dir, $addPath);
        }
        return true;
    }

    private function _updateResourceDir($oldDir, $newDir)
    {
        foreach ($oldDir as $directory) {
            $length = strlen($directory);
            foreach ($this->_resource_dir as $dir) {
                if (substr($dir, 0, $length) === $directory) {
                    unset($this->_resource_dir[$dir]);
                }
            }
        }
        foreach ($newDir as $directory) {
            $this->_resource_dir[$directory] = true;
        }
    }

    private function _checkDir($filepath, $dirs)
    {
        $directory = dirname($this->smarty->_realpath($filepath, true)) . DIRECTORY_SEPARATOR;
        $_directory = array();
        if (!preg_match('#[\\\\/][.][.][\\\\/]#', $directory)) {
            while (true) {
                if (isset($dirs[$directory])) {
                    return $_directory;
                }
                if (!preg_match('#[\\\\/][^\\\\/]+[\\\\/]$#', $directory)) {
                    break;
                }
                $_directory[$directory] = true;
                $directory = preg_replace('#[\\\\/][^\\\\/]+[\\\\/]$#', DIRECTORY_SEPARATOR, $directory);
            }
        }
        throw new SmartyException(sprintf('Smarty Security: not trusted file path \'%s\' ', $filepath));
    }

    public function isTrustedUri($uri)
    {
        $_uri = parse_url($uri);
        if (!empty($_uri['scheme']) && !empty($_uri['host'])) {
            $_uri = $_uri['scheme'] . '://' . $_uri['host'];
            foreach ($this->trusted_uri as $pattern) {
                if (preg_match($pattern, $_uri)) {
                    return true;
                }
            }
        }
        throw new SmartyException("URI '{$uri}' not allowed by security setting");
    }

    public function startTemplate($template)
    {
        if ($this->max_template_nesting > 0 && $this->_current_template_nesting++ >= $this->max_template_nesting) {
            throw new SmartyException("maximum template nesting level of '{$this->max_template_nesting}' exceeded when calling '{$template->template_resource}'");
        }
    }

    public function endTemplate()
    {
        if ($this->max_template_nesting > 0) {
            $this->_current_template_nesting--;
        }
    }

    public function registerCallBacks(Smarty_Internal_Template $template)
    {
        $template->startRenderCallbacks[] = array($this, 'startTemplate');
        $template->endRenderCallbacks[] = array($this, 'endTemplate');
    }
}