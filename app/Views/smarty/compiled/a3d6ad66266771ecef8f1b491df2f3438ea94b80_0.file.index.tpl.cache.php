<?php
/* Smarty version 3.1.36, created on 2020-11-08 07:39:01
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\general\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa7e6e557b945_43811613',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            'a3d6ad66266771ecef8f1b491df2f3438ea94b80' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\general\\index.tpl',
                    1 => 1604536676,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(
            'file:_head.tpl' => 1,
            'file:navbar.tpl' => 1,
            'file:main.tpl' => 1,
            'file:_footer.tpl' => 1,
            'file:general/modals/signin.tpl' => 1,
            'file:general/modals/confirm-logout.tpl' => 1,
            'file:general/modals/wrong-access.tpl' => 1,
            'file:general/modals/access-granted.tpl' => 1,
        ),
), false)) {
    function content_5fa7e6e557b945_43811613(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '11763126815fa7e6e5575e68_01456109';
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
        <?php $_smarty_tpl->_subTemplateRender("file:general/modals/signin.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
        ?>
        <?php $_smarty_tpl->_subTemplateRender("file:general/modals/confirm-logout.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
        ?>
        <?php if ((isset($_smarty_tpl->tpl_vars['extra']->value))) { ?>
            <?php if ($_smarty_tpl->tpl_vars['extra']->value == 'wrong-access') { ?>
                <?php $_smarty_tpl->_subTemplateRender("file:general/modals/wrong-access.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
                ?>
            <?php } elseif ($_smarty_tpl->tpl_vars['extra']->value == 'access-granted') { ?>
                <?php $_smarty_tpl->_subTemplateRender("file:general/modals/access-granted.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
                ?>
            <?php } ?>
        <?php } ?>
    </div>
    </body>
        </html><?php }
}
