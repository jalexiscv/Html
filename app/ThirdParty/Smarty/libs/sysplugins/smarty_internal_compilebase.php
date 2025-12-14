<?php

abstract class Smarty_Internal_CompileBase
{
    public $required_attributes = array();
    public $optional_attributes = array();
    public $shorttag_order = array();
    public $option_flags = array('nocache');
    public $optionMap = array(1 => true, 0 => false, 'true' => true, 'false' => false);
    public $mapCache = array();

    public function getAttributes($compiler, $attributes)
    {
        $_indexed_attr = array();
        if (!isset($this->mapCache['option'])) {
            $this->mapCache['option'] = array_fill_keys($this->option_flags, true);
        }
        foreach ($attributes as $key => $mixed) {
            if (!is_array($mixed)) {
                if (isset($this->mapCache['option'][trim($mixed, '\'"')])) {
                    $_indexed_attr[trim($mixed, '\'"')] = true;
                } elseif (isset($this->shorttag_order[$key])) {
                    $_indexed_attr[$this->shorttag_order[$key]] = $mixed;
                } else {
                    $compiler->trigger_template_error('too many shorthand attributes', null, true);
                }
            } else {
                foreach ($mixed as $k => $v) {
                    if (isset($this->mapCache['option'][$k])) {
                        if (is_bool($v)) {
                            $_indexed_attr[$k] = $v;
                        } else {
                            if (is_string($v)) {
                                $v = trim($v, '\'" ');
                            }
                            if (isset($this->optionMap[$v])) {
                                $_indexed_attr[$k] = $this->optionMap[$v];
                            } else {
                                $compiler->trigger_template_error("illegal value '" . var_export($v, true) . "' for option flag '{$k}'", null, true);
                            }
                        }
                    } else {
                        $_indexed_attr[$k] = $v;
                    }
                }
            }
        }
        foreach ($this->required_attributes as $attr) {
            if (!isset($_indexed_attr[$attr])) {
                $compiler->trigger_template_error("missing '{$attr}' attribute", null, true);
            }
        }
        if ($this->optional_attributes !== array('_any')) {
            if (!isset($this->mapCache['all'])) {
                $this->mapCache['all'] = array_fill_keys(array_merge($this->required_attributes, $this->optional_attributes, $this->option_flags), true);
            }
            foreach ($_indexed_attr as $key => $dummy) {
                if (!isset($this->mapCache['all'][$key]) && $key !== 0) {
                    $compiler->trigger_template_error("unexpected '{$key}' attribute", null, true);
                }
            }
        }
        foreach ($this->option_flags as $flag) {
            if (!isset($_indexed_attr[$flag])) {
                $_indexed_attr[$flag] = false;
            }
        }
        if (isset($_indexed_attr['nocache']) && $_indexed_attr['nocache']) {
            $compiler->tag_nocache = true;
        }
        return $_indexed_attr;
    }

    public function openTag($compiler, $openTag, $data = null)
    {
        array_push($compiler->_tag_stack, array($openTag, $data));
    }

    public function closeTag($compiler, $expectedTag)
    {
        if (count($compiler->_tag_stack) > 0) {
            list($_openTag, $_data) = array_pop($compiler->_tag_stack);
            if (in_array($_openTag, (array)$expectedTag)) {
                if (is_null($_data)) {
                    return $_openTag;
                } else {
                    return $_data;
                }
            }
            $compiler->trigger_template_error("unclosed '{$compiler->smarty->left_delimiter}{$_openTag}{$compiler->smarty->right_delimiter}' tag");
            return;
        }
        $compiler->trigger_template_error('unexpected closing tag', null, true);
        return;
    }
}