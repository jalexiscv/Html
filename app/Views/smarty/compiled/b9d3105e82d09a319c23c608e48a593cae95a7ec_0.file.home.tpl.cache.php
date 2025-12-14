<?php
/* Smarty version 3.1.36, created on 2020-11-08 07:37:42
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\social\posts\home.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa7e6963f8358_68077847',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            'b9d3105e82d09a319c23c608e48a593cae95a7ec' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\social\\posts\\home.tpl',
                    1 => 1603857687,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(
            'file:social/posts/topday.tpl' => 1,
            'file:social/posts/small.tpl' => 1,
        ),
), false)) {
    function content_5fa7e6963f8358_68077847(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '16301680095fa7e6963e8256_46437940';
        ?>

        <div class="row">
        <div
                class="col-md-4 d-none d-xl-block d-lg-block"><?php $_smarty_tpl->_subTemplateRender("file:social/posts/topday.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
            ?></div>
        <div
                class="col-md-8 col-sm-12 pl-md-0"><?php $_smarty_tpl->_subTemplateRender("file:social/posts/small.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
            ?></div>
        </div><?php }
}
