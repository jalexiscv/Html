<?php
/* Smarty version 3.1.36, created on 2020-11-08 07:39:01
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\navbar.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa7e6e55aa322_32256674',
    'has_nocache_code' => true,
    'file_dependency' =>
        array(
            'bc60ec6a72f080cba242d5d2ab943ca7ac088dea' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\navbar.tpl',
                    1 => 1600748318,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(
            'file:components/navbar-intro.tpl' => 1,
            'file:components/navbar-content-loggedin.tpl' => 1,
            'file:components/navbar-menu-loggedin.tpl' => 1,
            'file:components/navbar-content.tpl' => 1,
            'file:components/navbar-menu.tpl' => 1,
        ),
), false)) {
    function content_5fa7e6e55aa322_32256674(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '20912088935fa7e6e55a6de1_48765316';
        ?>
        <nav class="navbar navbar-expand-lg navbar-fixed navbar-default">
        <div class="navbar-inner">
            <?php $_smarty_tpl->_subTemplateRender("file:components/navbar-intro.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
            ?>
            <?php echo '/*%%SmartyNocache:20912088935fa7e6e55a6de1_48765316%%*/<?php if ($_smarty_tpl->tpl_vars[\'loggedin\']->value) {?>/*/%%SmartyNocache:20912088935fa7e6e55a6de1_48765316%%*/'; ?>

            <?php echo '/*%%SmartyNocache:20912088935fa7e6e55a6de1_48765316%%*/<?php $_smarty_tpl->_subTemplateRender("file:components/navbar-content-loggedin.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>/*/%%SmartyNocache:20912088935fa7e6e55a6de1_48765316%%*/'; ?>

            <?php echo '/*%%SmartyNocache:20912088935fa7e6e55a6de1_48765316%%*/<?php $_smarty_tpl->_subTemplateRender("file:components/navbar-menu-loggedin.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>/*/%%SmartyNocache:20912088935fa7e6e55a6de1_48765316%%*/'; ?>

            <?php echo '/*%%SmartyNocache:20912088935fa7e6e55a6de1_48765316%%*/<?php } else { ?>/*/%%SmartyNocache:20912088935fa7e6e55a6de1_48765316%%*/'; ?>

            <?php echo '/*%%SmartyNocache:20912088935fa7e6e55a6de1_48765316%%*/<?php $_smarty_tpl->_subTemplateRender("file:components/navbar-content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>/*/%%SmartyNocache:20912088935fa7e6e55a6de1_48765316%%*/'; ?>

            <?php echo '/*%%SmartyNocache:20912088935fa7e6e55a6de1_48765316%%*/<?php $_smarty_tpl->_subTemplateRender("file:components/navbar-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>/*/%%SmartyNocache:20912088935fa7e6e55a6de1_48765316%%*/'; ?>

            <?php echo '/*%%SmartyNocache:20912088935fa7e6e55a6de1_48765316%%*/<?php }?>/*/%%SmartyNocache:20912088935fa7e6e55a6de1_48765316%%*/'; ?>

        </div>
        </nav><?php }
}
