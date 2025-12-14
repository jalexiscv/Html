<?php
/* Smarty version 3.1.36, created on 2020-11-04 14:34:09
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\page.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa30231c1a465_22088262',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '45b0fbbf9f3c82b7e5b12807ace191707e992d08' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\page.tpl',
                    1 => 1602570443,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(
            'file:_head.tpl' => 1,
            'file:navbar.tpl' => 1,
            'file:main.tpl' => 1,
            'file:_footer.tpl' => 1,
            'file:modals/signin.tpl' => 1,
            'file:modals/confirm-logout.tpl' => 1,
        ),
), false)) {
    function content_5fa30231c1a465_22088262(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '12071391155fa30231c18069_38071650';
        ?>
        <!doctype html>
        <html lang="es">
    <head>
        <?php $_smarty_tpl->_subTemplateRender("file:_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
        ?>
    </head>
    <body data-hash="<?php echo csrf_hash(); ?>
" data-token="<?php echo csrf_token(); ?>
">
    <div class="body-container">
        <?php $_smarty_tpl->_subTemplateRender("file:navbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
        ?>
        <?php $_smarty_tpl->_subTemplateRender("file:main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
        ?>
        <?php $_smarty_tpl->_subTemplateRender("file:_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
        ?>
        <?php $_smarty_tpl->_subTemplateRender("file:modals/signin.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
        ?>
        <?php $_smarty_tpl->_subTemplateRender("file:modals/confirm-logout.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
        ?>
    </div>
    </body>
        </html><?php }
}
