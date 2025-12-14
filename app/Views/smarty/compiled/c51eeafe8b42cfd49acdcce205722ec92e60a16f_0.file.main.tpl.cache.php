<?php
/* Smarty version 3.1.36, created on 2020-10-19 09:52:44
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\posts\main.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5f8da83cc71425_37491881',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            'c51eeafe8b42cfd49acdcce205722ec92e60a16f' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\posts\\main.tpl',
                    1 => 1601778332,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(
            'file:posts/categories.tpl' => 1,
            'file:posts/small.tpl' => 1,
        ),
), false)) {
    function content_5f8da83cc71425_37491881(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '218692415f8da83cc68ce1_02037096';
        ?>

        <div class="row">
        <div
                class="col-md-4 d-none d-xl-block d-lg-block"><?php $_smarty_tpl->_subTemplateRender("file:posts/categories.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
            ?></div>
        <div
                class="col-md-8 col-sm-12 pl-md-0"><?php $_smarty_tpl->_subTemplateRender("file:posts/small.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
            ?></div>
        </div><?php }
}
