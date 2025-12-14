<?php
function smarty_variablefilter_htmlspecialchars($source, Smarty_Internal_Template $template)
{
    return htmlspecialchars($source, ENT_QUOTES, Smarty::$_CHARSET);
}