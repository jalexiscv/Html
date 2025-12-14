<?php
/* Smarty version 3.1.36, created on 2020-11-08 07:39:01
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa7e6e5568af0_90085304',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '986285b4c56862771956f098b569f077c182ed77' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\index.tpl',
                    1 => 1604614208,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(
            'file:general/index.tpl' => 1,
            'file:signin.tpl' => 1,
            'file:welcome.tpl' => 1,
            'file:acredit/index.tpl' => 1,
            'file:spa/index.tpl' => 1,
            'file:etc.tpl' => 1,
        ),
), false)) {
    function content_5fa7e6e5568af0_90085304(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '14382851125fa7e6e5562c00_22168180';
        if ((isset($_smarty_tpl->tpl_vars['page_template']->value))) { ?>
            <?php if ($_smarty_tpl->tpl_vars['page_template']->value == "page") { ?>
                <?php $_smarty_tpl->_subTemplateRender("file:general/index.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
                ?>
            <?php } elseif ($_smarty_tpl->tpl_vars['page_template']->value == "signin") { ?>
                <?php $_smarty_tpl->_subTemplateRender("file:signin.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
                ?>
            <?php } elseif ($_smarty_tpl->tpl_vars['page_template']->value == "welcome") { ?>
                <?php $_smarty_tpl->_subTemplateRender("file:welcome.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
                ?>
            <?php } elseif ($_smarty_tpl->tpl_vars['page_template']->value == "page-acredit") { ?>
                <?php $_smarty_tpl->_subTemplateRender("file:acredit/index.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
                ?>
            <?php } elseif ($_smarty_tpl->tpl_vars['page_template']->value == "page-spa") { ?>
                <?php $_smarty_tpl->_subTemplateRender("file:spa/index.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
                ?>
            <?php } else { ?>
                <?php $_smarty_tpl->_subTemplateRender("file:etc.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
                ?>
            <?php }
        }
    }
}
