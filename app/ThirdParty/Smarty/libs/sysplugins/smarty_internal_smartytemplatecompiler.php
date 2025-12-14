<?php

class Smarty_Internal_SmartyTemplateCompiler extends Smarty_Internal_TemplateCompilerBase
{
    public $lexer_class;
    public $parser_class;
    public $local_var = array();
    public $postCompileCallbacks = array();
    public $prefixCompiledCode = '';
    public $postfixCompiledCode = '';

    public function __construct($lexer_class, $parser_class, Smarty $smarty)
    {
        parent::__construct($smarty);
        $this->lexer_class = $lexer_class;
        $this->parser_class = $parser_class;
    }

    public function registerPostCompileCallback($callback, $parameter = array(), $key = null, $replace = false)
    {
        array_unshift($parameter, $callback);
        if (isset($key)) {
            if ($replace || !isset($this->postCompileCallbacks[$key])) {
                $this->postCompileCallbacks[$key] = $parameter;
            }
        } else {
            $this->postCompileCallbacks[] = $parameter;
        }
    }

    public function unregisterPostCompileCallback($key)
    {
        unset($this->postCompileCallbacks[$key]);
    }

    protected function doCompile($_content, $isTemplateSource = false)
    {
        $this->parser = new $this->parser_class(new $this->lexer_class(str_replace(array("\r\n", "\r"), "\n", $_content), $this), $this);
        if ($isTemplateSource && $this->template->caching) {
            $this->parser->insertPhpCode("<?php\n\$_smarty_tpl->compiled->nocache_hash = '{$this->nocache_hash}';\n?>\n");
        }
        if (function_exists('mb_internal_encoding') && function_exists('ini_get') && ((int)ini_get('mbstring.func_overload')) & 2) {
            $mbEncoding = mb_internal_encoding();
            mb_internal_encoding('ASCII');
        } else {
            $mbEncoding = null;
        }
        if ($this->smarty->_parserdebug) {
            $this->parser->PrintTrace();
            $this->parser->lex->PrintTrace();
        }
        while ($this->parser->lex->yylex()) {
            if ($this->smarty->_parserdebug) {
                echo "<pre>Line {$this->parser->lex->line} Parsing  {$this->parser->yyTokenName[$this->parser->lex->token]} Token " . htmlentities($this->parser->lex->value) . "</pre>";
            }
            $this->parser->doParse($this->parser->lex->token, $this->parser->lex->value);
        }
        $this->parser->doParse(0, 0);
        if ($mbEncoding) {
            mb_internal_encoding($mbEncoding);
        }
        if (count($this->_tag_stack) > 0) {
            list($openTag, $_data) = array_pop($this->_tag_stack);
            $this->trigger_template_error("unclosed {$this->smarty->left_delimiter}" . $openTag . "{$this->smarty->right_delimiter} tag");
        }
        foreach ($this->postCompileCallbacks as $cb) {
            $parameter = $cb;
            $parameter[0] = $this;
            call_user_func_array($cb[0], $parameter);
        }
        return $this->prefixCompiledCode . $this->parser->retvalue . $this->postfixCompiledCode;
    }
}