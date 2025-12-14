<?php
/* Smarty version 3.1.36, created on 2020-10-01 12:56:52
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\alerts\light-danger.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5f761864eac265_89722364',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '4d5085417e0da694edd3f83bc883ab400ce67520' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\alerts\\light-danger.tpl',
                    1 => 1595388130,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5f761864eac265_89722364(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '314815725f761864eaa1a5_37760014';
        ?>
        <div class="alert d-flex bgc-danger-l4 text-dark-tp3 radius-0 text-120 brc-danger-l3" role="alert">
        <div class="position-tl h-102 ml-n1px border-l-4 brc-danger-tp3 m-n1px"></div>
        <i class="fas fa-exclamation-circle mr-3 fa-2x text-warning-d2 opacity-1"></i>
        <span class="align-self-center text-70"><?php echo $_smarty_tpl->tpl_vars['message']->value; ?>
</span>
        </div><?php }
}
