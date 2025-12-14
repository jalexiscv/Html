<?php

abstract class Smarty_Internal_TemplateCompilerBase
{
    public static $_tag_objects = array();
    public static $prefixVariableNumber = 0;
    public $smarty = null;
    public $parser = null;
    public $nocache_hash = null;
    public $suppressNocacheProcessing = false;
    public $caching = 0;
    public $_tag_stack = array();
    public $_tag_stack_count = array();
    public $required_plugins = array('compiled' => array(), 'nocache' => array());
    public $required_plugins_stack = array();
    public $template = null;
    public $mergedSubTemplatesData = array();
    public $mergedSubTemplatesCode = array();
    public $templateProperties = array();
    public $trace_line_offset = 0;
    public $trace_uid = '';
    public $trace_filepath = '';
    public $trace_stack = array();
    public $default_handler_plugins = array();
    public $default_modifier_list = null;
    public $forceNocache = false;
    public $write_compiled_code = true;
    public $tpl_function = array();
    public $called_functions = array();
    public $blockOrFunctionCode = '';
    public $modifier_plugins = array();
    public $known_modifier_type = array();
    public $parent_compiler = null;
    public $nocache = false;
    public $tag_nocache = false;
    public $prefix_code = array();
    public $usedPrefixVariables = array();
    public $prefixCodeStack = array();
    public $has_code = false;
    public $has_variable_string = false;
    public $variable_filter_stack = array();
    public $variable_filters = array();
    public $loopNesting = 0;
    public $stripRegEx = '![\t ]*[\r\n]+[\t ]*!';
    public $plugin_search_order = array('function', 'block', 'compiler', 'class');
    public $_cache = array();
    private $ldelPreg = '[{]';
    private $rdelPreg = '[}]';
    private $rdelLength = 0;
    private $ldelLength = 0;
    private $literalPreg = '';

    public function __construct(Smarty $smarty)
    {
        $this->smarty = $smarty;
        $this->nocache_hash = str_replace(array('.', ','), '_', uniqid(mt_rand(), true));
    }

    public function compileTemplate(Smarty_Internal_Template $template, $nocache = null, Smarty_Internal_TemplateCompilerBase $parent_compiler = null)
    {
        $_compiled_code = $template->smarty->ext->_codeFrame->create($template, $this->compileTemplateSource($template, $nocache, $parent_compiler), $this->postFilter($this->blockOrFunctionCode) . join('', $this->mergedSubTemplatesCode), false, $this);
        return $_compiled_code;
    }

    public function compileTemplateSource(Smarty_Internal_Template $template, $nocache = null, Smarty_Internal_TemplateCompilerBase $parent_compiler = null)
    {
        try {
            $this->template = $template;
            if ($this->smarty->debugging) {
                if (!isset($this->smarty->_debug)) {
                    $this->smarty->_debug = new Smarty_Internal_Debug();
                }
                $this->smarty->_debug->start_compile($this->template);
            }
            $this->parent_compiler = $parent_compiler ? $parent_compiler : $this;
            $nocache = isset($nocache) ? $nocache : false;
            if (empty($template->compiled->nocache_hash)) {
                $template->compiled->nocache_hash = $this->nocache_hash;
            } else {
                $this->nocache_hash = $template->compiled->nocache_hash;
            }
            $this->caching = $template->caching;
            $this->nocache = $nocache;
            $this->tag_nocache = false;
            $this->template->compiled->has_nocache_code = false;
            $this->has_variable_string = false;
            $this->prefix_code = array();
            if ($this->smarty->merge_compiled_includes || $this->template->source->handler->checkTimestamps()) {
                $this->parent_compiler->template->compiled->file_dependency[$this->template->source->uid] = array($this->template->source->filepath, $this->template->source->getTimeStamp(), $this->template->source->type,);
            }
            $this->smarty->_current_file = $this->template->source->filepath;
            if (!empty($this->template->source->components)) {
                $_content = Smarty_Internal_Compile_Extends::extendsSourceArrayCode($this->template);
            } else {
                $_content = $this->template->source->getContent();
            }
            $_compiled_code = $this->postFilter($this->doCompile($this->preFilter($_content), true));
            if (!empty($this->required_plugins['compiled']) || !empty($this->required_plugins['nocache'])) {
                $_compiled_code = '<?php ' . $this->compileRequiredPlugins() . "?>\n" . $_compiled_code;
            }
        } catch (Exception $e) {
            if ($this->smarty->debugging) {
                $this->smarty->_debug->end_compile($this->template);
            }
            $this->_tag_stack = array();
            $this->parent_compiler = null;
            $this->template = null;
            $this->parser = null;
            throw $e;
        }
        if ($this->smarty->debugging) {
            $this->smarty->_debug->end_compile($this->template);
        }
        $this->parent_compiler = null;
        $this->parser = null;
        return $_compiled_code;
    }

    public function postFilter($code)
    {
        if (!empty($code) && (isset($this->smarty->autoload_filters['post']) || isset($this->smarty->registered_filters['post']))) {
            return $this->smarty->ext->_filterHandler->runFilter('post', $code, $this->template);
        } else {
            return $code;
        }
    }

    abstract protected function doCompile($_content, $isTemplateSource = false);

    public function preFilter($_content)
    {
        if ($_content !== '' && ((isset($this->smarty->autoload_filters['pre']) || isset($this->smarty->registered_filters['pre'])))) {
            return $this->smarty->ext->_filterHandler->runFilter('pre', $_content, $this->template);
        } else {
            return $_content;
        }
    }

    public function compileRequiredPlugins()
    {
        $code = $this->compileCheckPlugins($this->required_plugins['compiled']);
        if ($this->caching && !empty($this->required_plugins['nocache'])) {
            $code .= $this->makeNocacheCode($this->compileCheckPlugins($this->required_plugins['nocache']));
        }
        return $code;
    }

    public function compileCheckPlugins($requiredPlugins)
    {
        if (!empty($requiredPlugins)) {
            $plugins = array();
            foreach ($requiredPlugins as $plugin) {
                foreach ($plugin as $data) {
                    $plugins[] = $data;
                }
            }
            return '$_smarty_tpl->_checkPlugins(' . $this->getVarExport($plugins) . ');' . "\n";
        } else {
            return '';
        }
    }

    public function getVarExport($value)
    {
        return preg_replace('/\s/', '', var_export($value, true));
    }

    public function makeNocacheCode($code)
    {
        return "echo '/*%%SmartyNocache:{$this->nocache_hash}%%*/<?php " . str_replace('^#^', '\'', addcslashes($code, '\'\\')) . "?>/*/%%SmartyNocache:{$this->nocache_hash}%%*/';\n";
    }

    public function compileTag($tag, $args, $parameter = array())
    {
        $this->prefixCodeStack[] = $this->prefix_code;
        $this->prefix_code = array();
        $result = $this->compileTag2($tag, $args, $parameter);
        $this->prefix_code = array_merge($this->prefix_code, array_pop($this->prefixCodeStack));
        return $result;
    }

    private function compileTag2($tag, $args, $parameter)
    {
        $plugin_type = '';
        $this->has_code = true;
        if (isset($this->smarty->_cache['get_used_tags'])) {
            $this->template->_cache['used_tags'][] = array($tag, $args);
        }
        foreach ($args as $arg) {
            if (!is_array($arg)) {
                if ($arg === "'nocache'" || $arg === 'nocache') {
                    $this->tag_nocache = true;
                }
            } else {
                foreach ($arg as $k => $v) {
                    if (($k === "'nocache'" || $k === 'nocache') && (trim($v, "'\" ") === 'true')) {
                        $this->tag_nocache = true;
                    }
                }
            }
        }
        if (($_output = $this->callTagCompiler($tag, $args, $parameter)) === false) {
            if (isset($this->parent_compiler->tpl_function[$tag]) || (isset($this->template->smarty->ext->_tplFunction) && $this->template->smarty->ext->_tplFunction->getTplFunction($this->template, $tag) !== false)) {
                $args['_attr']['name'] = "'{$tag}'";
                $_output = $this->callTagCompiler('call', $args, $parameter);
            }
        }
        if ($_output !== false) {
            if ($_output !== true) {
                if ($this->has_code) {
                    return $_output;
                }
            }
            return null;
        } else {
            if (isset($args['_attr'])) {
                foreach ($args['_attr'] as $key => $attribute) {
                    if (is_array($attribute)) {
                        $args = array_merge($args, $attribute);
                    }
                }
            }
            if (strlen($tag) < 6 || substr($tag, -5) !== 'close') {
                if (isset($this->smarty->registered_objects[$tag]) && isset($parameter['object_method'])) {
                    $method = $parameter['object_method'];
                    if (!in_array($method, $this->smarty->registered_objects[$tag][3]) && (empty($this->smarty->registered_objects[$tag][1]) || in_array($method, $this->smarty->registered_objects[$tag][1]))) {
                        return $this->callTagCompiler('private_object_function', $args, $parameter, $tag, $method);
                    } elseif (in_array($method, $this->smarty->registered_objects[$tag][3])) {
                        return $this->callTagCompiler('private_object_block_function', $args, $parameter, $tag, $method);
                    } else {
                        $this->trigger_template_error('not allowed method "' . $method . '" in registered object "' . $tag . '"', null, true);
                    }
                }
                foreach (array(Smarty::PLUGIN_COMPILER, Smarty::PLUGIN_FUNCTION, Smarty::PLUGIN_BLOCK,) as $plugin_type) {
                    if (isset($this->smarty->registered_plugins[$plugin_type][$tag])) {
                        if ($plugin_type === Smarty::PLUGIN_COMPILER) {
                            $new_args = array();
                            foreach ($args as $key => $mixed) {
                                if (is_array($mixed)) {
                                    $new_args = array_merge($new_args, $mixed);
                                } else {
                                    $new_args[$key] = $mixed;
                                }
                            }
                            if (!$this->smarty->registered_plugins[$plugin_type][$tag][1]) {
                                $this->tag_nocache = true;
                            }
                            return call_user_func_array($this->smarty->registered_plugins[$plugin_type][$tag][0], array($new_args, $this));
                        }
                        if ($plugin_type === Smarty::PLUGIN_FUNCTION || $plugin_type === Smarty::PLUGIN_BLOCK) {
                            return $this->callTagCompiler('private_registered_' . $plugin_type, $args, $parameter, $tag);
                        }
                    }
                }
                foreach ($this->plugin_search_order as $plugin_type) {
                    if ($plugin_type === Smarty::PLUGIN_COMPILER && $this->smarty->loadPlugin('smarty_compiler_' . $tag) && (!isset($this->smarty->security_policy) || $this->smarty->security_policy->isTrustedTag($tag, $this))) {
                        $plugin = 'smarty_compiler_' . $tag;
                        if (is_callable($plugin)) {
                            $new_args = array();
                            foreach ($args as $key => $mixed) {
                                if (is_array($mixed)) {
                                    $new_args = array_merge($new_args, $mixed);
                                } else {
                                    $new_args[$key] = $mixed;
                                }
                            }
                            return $plugin($new_args, $this->smarty);
                        }
                        if (class_exists($plugin, false)) {
                            $plugin_object = new $plugin;
                            if (method_exists($plugin_object, 'compile')) {
                                return $plugin_object->compile($args, $this);
                            }
                        }
                        throw new SmartyException("Plugin '{$tag}' not callable");
                    } else {
                        if ($function = $this->getPlugin($tag, $plugin_type)) {
                            if (!isset($this->smarty->security_policy) || $this->smarty->security_policy->isTrustedTag($tag, $this)) {
                                return $this->callTagCompiler('private_' . $plugin_type . '_plugin', $args, $parameter, $tag, $function);
                            }
                        }
                    }
                }
                if (is_callable($this->smarty->default_plugin_handler_func)) {
                    $found = false;
                    foreach ($this->plugin_search_order as $plugin_type) {
                        if (isset($this->default_handler_plugins[$plugin_type][$tag])) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        foreach ($this->plugin_search_order as $plugin_type) {
                            if ($this->getPluginFromDefaultHandler($tag, $plugin_type)) {
                                $found = true;
                                break;
                            }
                        }
                    }
                    if ($found) {
                        if ($plugin_type === Smarty::PLUGIN_COMPILER) {
                            $new_args = array();
                            foreach ($args as $key => $mixed) {
                                if (is_array($mixed)) {
                                    $new_args = array_merge($new_args, $mixed);
                                } else {
                                    $new_args[$key] = $mixed;
                                }
                            }
                            return call_user_func_array($this->default_handler_plugins[$plugin_type][$tag][0], array($new_args, $this));
                        } else {
                            return $this->callTagCompiler('private_registered_' . $plugin_type, $args, $parameter, $tag);
                        }
                    }
                }
            } else {
                $base_tag = substr($tag, 0, -5);
                if (isset($this->smarty->registered_objects[$base_tag]) && isset($parameter['object_method'])) {
                    $method = $parameter['object_method'];
                    if (in_array($method, $this->smarty->registered_objects[$base_tag][3])) {
                        return $this->callTagCompiler('private_object_block_function', $args, $parameter, $tag, $method);
                    } else {
                        $this->trigger_template_error('not allowed closing tag method "' . $method . '" in registered object "' . $base_tag . '"', null, true);
                    }
                }
                if (isset($this->smarty->registered_plugins[Smarty::PLUGIN_BLOCK][$base_tag]) || isset($this->default_handler_plugins[Smarty::PLUGIN_BLOCK][$base_tag])) {
                    return $this->callTagCompiler('private_registered_block', $args, $parameter, $tag);
                }
                if (isset($this->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION][$tag])) {
                    return $this->callTagCompiler('private_registered_function', $args, $parameter, $tag);
                }
                if ($function = $this->getPlugin($base_tag, Smarty::PLUGIN_BLOCK)) {
                    return $this->callTagCompiler('private_block_plugin', $args, $parameter, $tag, $function);
                }
                if ($function = $this->getPlugin($tag, Smarty::PLUGIN_FUNCTION)) {
                    if (!isset($this->smarty->security_policy) || $this->smarty->security_policy->isTrustedTag($tag, $this)) {
                        return $this->callTagCompiler('private_function_plugin', $args, $parameter, $tag, $function);
                    }
                }
                if (isset($this->smarty->registered_plugins[Smarty::PLUGIN_COMPILER][$tag])) {
                    $args = array();
                    if (!$this->smarty->registered_plugins[Smarty::PLUGIN_COMPILER][$tag][1]) {
                        $this->tag_nocache = true;
                    }
                    return call_user_func_array($this->smarty->registered_plugins[Smarty::PLUGIN_COMPILER][$tag][0], array($args, $this));
                }
                if ($this->smarty->loadPlugin('smarty_compiler_' . $tag)) {
                    $plugin = 'smarty_compiler_' . $tag;
                    if (is_callable($plugin)) {
                        return $plugin($args, $this->smarty);
                    }
                    if (class_exists($plugin, false)) {
                        $plugin_object = new $plugin;
                        if (method_exists($plugin_object, 'compile')) {
                            return $plugin_object->compile($args, $this);
                        }
                    }
                    throw new SmartyException("Plugin '{$tag}' not callable");
                }
            }
            $this->trigger_template_error("unknown tag '{$tag}'", null, true);
        }
    }

    public function callTagCompiler($tag, $args, $param1 = null, $param2 = null, $param3 = null)
    {
        $tagCompiler = $this->getTagCompiler($tag);
        return $tagCompiler === false ? false : $tagCompiler->compile($args, $this, $param1, $param2, $param3);
    }

    public function getTagCompiler($tag)
    {
        if (!isset(self::$_tag_objects[$tag])) {
            $_tag = explode('_', $tag);
            $_tag = array_map('smarty_ucfirst_ascii', $_tag);
            $class_name = 'Smarty_Internal_Compile_' . implode('_', $_tag);
            if (class_exists($class_name) && (!isset($this->smarty->security_policy) || $this->smarty->security_policy->isTrustedTag($tag, $this))) {
                self::$_tag_objects[$tag] = new $class_name;
            } else {
                self::$_tag_objects[$tag] = false;
            }
        }
        return self::$_tag_objects[$tag];
    }

    public function trigger_template_error($args = null, $line = null, $tagline = null)
    {
        $lex = $this->parser->lex;
        if ($tagline === true) {
            $line = $lex->taglineno;
        } elseif (!isset($line)) {
            $line = $lex->line;
        } else {
            $line = (int)$line;
        }
        if (in_array($this->template->source->type, array('eval', 'string'))) {
            $templateName = $this->template->source->type . ':' . trim(preg_replace('![\t\r\n]+!', ' ', strlen($lex->data) > 40 ? substr($lex->data, 0, 40) . '...' : $lex->data));
        } else {
            $templateName = $this->template->source->type . ':' . $this->template->source->filepath;
        }
        $match = preg_split("/\n/", $lex->data);
        $error_text = 'Syntax error in template "' . (empty($this->trace_filepath) ? $templateName : $this->trace_filepath) . '"  on line ' . ($line + $this->trace_line_offset) . ' "' . trim(preg_replace('![\t\r\n]+!', ' ', $match[$line - 1])) . '" ';
        if (isset($args)) {
            $error_text .= $args;
        } else {
            $expect = array();
            $error_text .= ' - Unexpected "' . $lex->value . '"';
            if (count($this->parser->yy_get_expected_tokens($this->parser->yymajor)) <= 4) {
                foreach ($this->parser->yy_get_expected_tokens($this->parser->yymajor) as $token) {
                    $exp_token = $this->parser->yyTokenName[$token];
                    if (isset($lex->smarty_token_names[$exp_token])) {
                        $expect[] = '"' . $lex->smarty_token_names[$exp_token] . '"';
                    } else {
                        $expect[] = $this->parser->yyTokenName[$token];
                    }
                }
                $error_text .= ', expected one of: ' . implode(' , ', $expect);
            }
        }
        if ($this->smarty->_parserdebug) {
            $this->parser->errorRunDown();
            echo ob_get_clean();
            flush();
        }
        $e = new SmartyCompilerException($error_text, 0, $this->template->source->filepath, $line);
        $e->source = trim(preg_replace('![\t\r\n]+!', ' ', $match[$line - 1]));
        $e->desc = $args;
        $e->template = $this->template->source->filepath;
        throw $e;
    }

    public function getPlugin($plugin_name, $plugin_type)
    {
        $function = null;
        if ($this->caching && ($this->nocache || $this->tag_nocache)) {
            if (isset($this->required_plugins['nocache'][$plugin_name][$plugin_type])) {
                $function = $this->required_plugins['nocache'][$plugin_name][$plugin_type]['function'];
            } elseif (isset($this->required_plugins['compiled'][$plugin_name][$plugin_type])) {
                $this->required_plugins['nocache'][$plugin_name][$plugin_type] = $this->required_plugins['compiled'][$plugin_name][$plugin_type];
                $function = $this->required_plugins['nocache'][$plugin_name][$plugin_type]['function'];
            }
        } else {
            if (isset($this->required_plugins['compiled'][$plugin_name][$plugin_type])) {
                $function = $this->required_plugins['compiled'][$plugin_name][$plugin_type]['function'];
            } elseif (isset($this->required_plugins['nocache'][$plugin_name][$plugin_type])) {
                $this->required_plugins['compiled'][$plugin_name][$plugin_type] = $this->required_plugins['nocache'][$plugin_name][$plugin_type];
                $function = $this->required_plugins['compiled'][$plugin_name][$plugin_type]['function'];
            }
        }
        if (isset($function)) {
            if ($plugin_type === 'modifier') {
                $this->modifier_plugins[$plugin_name] = true;
            }
            return $function;
        }
        $function = 'smarty_' . $plugin_type . '_' . $plugin_name;
        $file = $this->smarty->loadPlugin($function, false);
        if (is_string($file)) {
            if ($this->caching && ($this->nocache || $this->tag_nocache)) {
                $this->required_plugins['nocache'][$plugin_name][$plugin_type]['file'] = $file;
                $this->required_plugins['nocache'][$plugin_name][$plugin_type]['function'] = $function;
            } else {
                $this->required_plugins['compiled'][$plugin_name][$plugin_type]['file'] = $file;
                $this->required_plugins['compiled'][$plugin_name][$plugin_type]['function'] = $function;
            }
            if ($plugin_type === 'modifier') {
                $this->modifier_plugins[$plugin_name] = true;
            }
            return $function;
        }
        if (is_callable($function)) {
            return $function;
        }
        return false;
    }

    public function getPluginFromDefaultHandler($tag, $plugin_type)
    {
        $callback = null;
        $script = null;
        $cacheable = true;
        $result = call_user_func_array($this->smarty->default_plugin_handler_func, array($tag, $plugin_type, $this->template, &$callback, &$script, &$cacheable,));
        if ($result) {
            $this->tag_nocache = $this->tag_nocache || !$cacheable;
            if ($script !== null) {
                if (is_file($script)) {
                    if ($this->caching && ($this->nocache || $this->tag_nocache)) {
                        $this->required_plugins['nocache'][$tag][$plugin_type]['file'] = $script;
                        $this->required_plugins['nocache'][$tag][$plugin_type]['function'] = $callback;
                    } else {
                        $this->required_plugins['compiled'][$tag][$plugin_type]['file'] = $script;
                        $this->required_plugins['compiled'][$tag][$plugin_type]['function'] = $callback;
                    }
                    include_once $script;
                } else {
                    $this->trigger_template_error("Default plugin handler: Returned script file '{$script}' for '{$tag}' not found");
                }
            }
            if (is_callable($callback)) {
                $this->default_handler_plugins[$plugin_type][$tag] = array($callback, true, array());
                return true;
            } else {
                $this->trigger_template_error("Default plugin handler: Returned callback for '{$tag}' not callable");
            }
        }
        return false;
    }

    public function compileVariable($variable)
    {
        if (!strpos($variable, '(')) {
            $var = trim($variable, '\'');
            $this->tag_nocache = $this->tag_nocache | $this->template->ext->getTemplateVars->_getVariable($this->template, $var, null, true, false)->nocache;
        }
        return '$_smarty_tpl->tpl_vars[' . $variable . ']->value';
    }

    public function compileConfigVariable($variable)
    {
        return '$_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, ' . $variable . ')';
    }

    public function compilePHPFunctionCall($name, $parameter)
    {
        if (!$this->smarty->security_policy || $this->smarty->security_policy->isTrustedPhpFunction($name, $this)) {
            if (strcasecmp($name, 'isset') === 0 || strcasecmp($name, 'empty') === 0 || strcasecmp($name, 'array') === 0 || is_callable($name)) {
                $func_name = smarty_strtolower_ascii($name);
                if ($func_name === 'isset') {
                    if (count($parameter) === 0) {
                        $this->trigger_template_error('Illegal number of parameter in "isset()"');
                    }
                    $pa = array();
                    foreach ($parameter as $p) {
                        $pa[] = $this->syntaxMatchesVariable($p) ? 'isset(' . $p . ')' : '(' . $p . ' !== null )';
                    }
                    return '(' . implode(' && ', $pa) . ')';
                } elseif (in_array($func_name, array('empty', 'reset', 'current', 'end', 'prev', 'next'))) {
                    if (count($parameter) !== 1) {
                        $this->trigger_template_error("Illegal number of parameter in '{$func_name()}'");
                    }
                    if ($func_name === 'empty') {
                        return $func_name . '(' . str_replace("')->value", "',null,true,false)->value", $parameter[0]) . ')';
                    } else {
                        return $func_name . '(' . $parameter[0] . ')';
                    }
                } else {
                    return $name . '(' . implode(',', $parameter) . ')';
                }
            } else {
                $this->trigger_template_error("unknown function '{$name}'");
            }
        }
    }

    private function syntaxMatchesVariable($string)
    {
        static $regex_pattern = '/^\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*((->)[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*|\[.*]*\])*$/';
        return 1 === preg_match($regex_pattern, trim($string));
    }

    public function processText($text)
    {
        if (strpos($text, '<') === false) {
            return preg_replace($this->stripRegEx, '', $text);
        }
        $store = array();
        $_store = 0;
        $_offset = 0;
        if (preg_match_all('#(<script[^>]*>.*?</script[^>]*>)|(<textarea[^>]*>.*?</textarea[^>]*>)|(<pre[^>]*>.*?</pre[^>]*>)#is', $text, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $store[] = $match[0][0];
                $_length = strlen($match[0][0]);
                $replace = '@!@SMARTY:' . $_store . ':SMARTY@!@';
                $text = substr_replace($text, $replace, $match[0][1] - $_offset, $_length);
                $_offset += $_length - strlen($replace);
                $_store++;
            }
        }
        $expressions = array('#(:SMARTY@!@|>)[\040\011]+(?=@!@SMARTY:|<)#s' => '\1 \2', '#(:SMARTY@!@|>)[\040\011]*[\n]\s*(?=@!@SMARTY:|<)#s' => '\1\2', '#(([a-z0-9]\s*=\s*("[^"]*?")|(\'[^\']*?\'))|<[a-z0-9_]+)\s+([a-z/>])#is' => '\1 \5', '#>[\040\011]+$#Ss' => '> ', '#>[\040\011]*[\n]\s*$#Ss' => '>', $this->stripRegEx => '',);
        $text = preg_replace(array_keys($expressions), array_values($expressions), $text);
        $_offset = 0;
        if (preg_match_all('#@!@SMARTY:([0-9]+):SMARTY@!@#is', $text, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $_length = strlen($match[0][0]);
                $replace = $store[$match[1][0]];
                $text = substr_replace($text, $replace, $match[0][1] + $_offset, $_length);
                $_offset += strlen($replace) - $_length;
                $_store++;
            }
        }
        return $text;
    }

    public function processNocacheCode($content, $is_code)
    {
        if ($is_code && !empty($content)) {
            if ((!($this->template->source->handler->recompiled) || $this->forceNocache) && $this->caching && !$this->suppressNocacheProcessing && ($this->nocache || $this->tag_nocache)) {
                $this->template->compiled->has_nocache_code = true;
                $_output = addcslashes($content, '\'\\');
                $_output = str_replace('^#^', '\'', $_output);
                $_output = "<?php echo '/*%%SmartyNocache:{$this->nocache_hash}%%*/{$_output}/*/%%SmartyNocache:{$this->nocache_hash}%%*/';?>\n";
                foreach ($this->modifier_plugins as $plugin_name => $dummy) {
                    if (isset($this->required_plugins['compiled'][$plugin_name]['modifier'])) {
                        $this->required_plugins['nocache'][$plugin_name]['modifier'] = $this->required_plugins['compiled'][$plugin_name]['modifier'];
                    }
                }
            } else {
                $_output = $content;
            }
        } else {
            $_output = $content;
        }
        $this->modifier_plugins = array();
        $this->suppressNocacheProcessing = false;
        $this->tag_nocache = false;
        return $_output;
    }

    public function getVariableName($input)
    {
        if (preg_match('~^[$]_smarty_tpl->tpl_vars\[[\'"]*([0-9]*[a-zA-Z_]\w*)[\'"]*\]->value$~', $input, $match)) {
            return $match[1];
        }
        return false;
    }

    public function setNocacheInVariable($varName)
    {
        if ($_var = $this->getId($varName)) {
            if (isset($this->template->tpl_vars[$_var])) {
                $this->template->tpl_vars[$_var] = clone $this->template->tpl_vars[$_var];
                $this->template->tpl_vars[$_var]->nocache = true;
            } else {
                $this->template->tpl_vars[$_var] = new Smarty_Variable(null, true);
            }
        }
    }

    public function getId($input)
    {
        if (preg_match('~^([\'"]*)([0-9]*[a-zA-Z_]\w*)\1$~', $input, $match)) {
            return $match[2];
        }
        return false;
    }

    public function convertScope($_attr, $validScopes)
    {
        $_scope = 0;
        if (isset($_attr['scope'])) {
            $_scopeName = trim($_attr['scope'], '\'"');
            if (is_numeric($_scopeName) && in_array($_scopeName, $validScopes)) {
                $_scope = $_scopeName;
            } elseif (is_string($_scopeName)) {
                $_scopeName = trim($_scopeName, '\'"');
                $_scope = isset($validScopes[$_scopeName]) ? $validScopes[$_scopeName] : false;
            } else {
                $_scope = false;
            }
            if ($_scope === false) {
                $err = var_export($_scopeName, true);
                $this->trigger_template_error("illegal value '{$err}' for \"scope\" attribute", null, true);
            }
        }
        return $_scope;
    }

    public function enterDoubleQuote()
    {
        array_push($this->_tag_stack_count, $this->getTagStackCount());
    }

    public function getTagStackCount()
    {
        return count($this->_tag_stack);
    }

    public function replaceDelimiter($lexerPreg)
    {
        return str_replace(array('SMARTYldel', 'SMARTYliteral', 'SMARTYrdel', 'SMARTYautoliteral', 'SMARTYal'), array($this->ldelPreg, $this->literalPreg, $this->rdelPreg, $this->smarty->getAutoLiteral() ? '{1,}' : '{9}', $this->smarty->getAutoLiteral() ? '' : '\\s*'), $lexerPreg);
    }

    public function initDelimiterPreg()
    {
        $ldel = $this->smarty->getLeftDelimiter();
        $this->ldelLength = strlen($ldel);
        $this->ldelPreg = '';
        foreach (str_split($ldel, 1) as $chr) {
            $this->ldelPreg .= '[' . preg_quote($chr, '/') . ']';
        }
        $rdel = $this->smarty->getRightDelimiter();
        $this->rdelLength = strlen($rdel);
        $this->rdelPreg = '';
        foreach (str_split($rdel, 1) as $chr) {
            $this->rdelPreg .= '[' . preg_quote($chr, '/') . ']';
        }
        $literals = $this->smarty->getLiterals();
        if (!empty($literals)) {
            foreach ($literals as $key => $literal) {
                $literalPreg = '';
                foreach (str_split($literal, 1) as $chr) {
                    $literalPreg .= '[' . preg_quote($chr, '/') . ']';
                }
                $literals[$key] = $literalPreg;
            }
            $this->literalPreg = '|' . implode('|', $literals);
        } else {
            $this->literalPreg = '';
        }
    }

    public function leaveDoubleQuote()
    {
        if (array_pop($this->_tag_stack_count) !== $this->getTagStackCount()) {
            $tag = $this->getOpenBlockTag();
            $this->trigger_template_error("unclosed '{{$tag}}' in doubled quoted string", null, true);
        }
    }

    public function getOpenBlockTag()
    {
        $tagCount = $this->getTagStackCount();
        if ($tagCount) {
            return $this->_tag_stack[$tagCount - 1][0];
        } else {
            return false;
        }
    }

    public function getLdelPreg()
    {
        return $this->ldelPreg;
    }

    public function getRdelPreg()
    {
        return $this->rdelPreg;
    }

    public function getLdelLength()
    {
        return $this->ldelLength;
    }

    public function getRdelLength()
    {
        return $this->rdelLength;
    }

    public function isVariable($value)
    {
        if (is_string($value)) {
            return preg_match('/[$(]/', $value);
        }
        if (is_bool($value) || is_numeric($value)) {
            return false;
        }
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                if ($this->isVariable($k) || $this->isVariable($v)) {
                    return true;
                }
            }
            return false;
        }
        return false;
    }

    public function getNewPrefixVariable()
    {
        ++self::$prefixVariableNumber;
        return $this->getPrefixVariable();
    }

    public function getPrefixVariable()
    {
        return '$_prefixVariable' . self::$prefixVariableNumber;
    }

    public function appendPrefixCode($code)
    {
        $this->prefix_code[] = $code;
    }

    public function getPrefixCode()
    {
        $code = '';
        $prefixArray = array_merge($this->prefix_code, array_pop($this->prefixCodeStack));
        $this->prefixCodeStack[] = array();
        foreach ($prefixArray as $c) {
            $code = $this->appendCode($code, $c);
        }
        $this->prefix_code = array();
        return $code;
    }

    public function appendCode($left, $right)
    {
        if (preg_match('/\s*\?>\s?$/D', $left) && preg_match('/^<\?php\s+/', $right)) {
            $left = preg_replace('/\s*\?>\s?$/D', "\n", $left);
            $left .= preg_replace('/^<\?php\s+/', '', $right);
        } else {
            $left .= $right;
        }
        return $left;
    }

    public function saveRequiredPlugins($init = false)
    {
        $this->required_plugins_stack[] = $this->required_plugins;
        if ($init) {
            $this->required_plugins = array('compiled' => array(), 'nocache' => array());
        }
    }

    public function restoreRequiredPlugins()
    {
        $this->required_plugins = array_pop($this->required_plugins_stack);
    }

    public function cStyleComment($string)
    {
        return '/*' . str_replace('*/', '* /', $string) . '*/';
    }
}