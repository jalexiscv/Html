<?php

class Smarty_Internal_Method_Literals
{
    public $objMap = 3;

    public function getLiterals(Smarty_Internal_TemplateBase $obj)
    {
        $smarty = $obj->_getSmartyObj();
        return (array)$smarty->literals;
    }

    public function addLiterals(Smarty_Internal_TemplateBase $obj, $literals = null)
    {
        if (isset($literals)) {
            $this->set($obj->_getSmartyObj(), (array)$literals);
        }
        return $obj;
    }

    private function set(Smarty $smarty, $literals)
    {
        $literals = array_combine($literals, $literals);
        $error = isset($literals[$smarty->left_delimiter]) ? array($smarty->left_delimiter) : array();
        $error = isset($literals[$smarty->right_delimiter]) ? $error[] = $smarty->right_delimiter : $error;
        if (!empty($error)) {
            throw new SmartyException('User defined literal(s) "' . $error . '" may not be identical with left or right delimiter');
        }
        $smarty->literals = array_merge((array)$smarty->literals, (array)$literals);
    }

    public function setLiterals(Smarty_Internal_TemplateBase $obj, $literals = null)
    {
        $smarty = $obj->_getSmartyObj();
        $smarty->literals = array();
        if (!empty($literals)) {
            $this->set($smarty, (array)$literals);
        }
        return $obj;
    }
}