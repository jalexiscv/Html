<?php
/* Smarty version 3.1.36, created on 2020-11-07 01:53:34
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\acredit\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa6446e971014_68518087',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            'fe0824d2d4a8d47cd8973d3f5ddb8b40aae8627a' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\acredit\\index.tpl',
                    1 => 1604614298,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(
            'file:_head.tpl' => 1,
            'file:navbar.tpl' => 1,
            'file:main.tpl' => 1,
            'file:_footer.tpl' => 1,
            'file:acredit/modals/signin.tpl' => 1,
            'file:acredit/modals/confirm-logout.tpl' => 1,
            'file:acredit/modals/wrong-access.tpl' => 1,
            'file:acredit/modals/access-granted.tpl' => 1,
        ),
), false)) {
    function content_5fa6446e971014_68518087(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '4463443415fa6446e967aa1_49340179';
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
        <?php $_smarty_tpl->_subTemplateRender("file:acredit/modals/signin.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
        ?>
        <?php $_smarty_tpl->_subTemplateRender("file:acredit/modals/confirm-logout.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
        ?>
        <?php if ((isset($_smarty_tpl->tpl_vars['extra']->value))) { ?>
            <?php if ($_smarty_tpl->tpl_vars['extra']->value == 'wrong-access') { ?>
                <?php $_smarty_tpl->_subTemplateRender("file:acredit/modals/wrong-access.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
                ?>
            <?php } elseif ($_smarty_tpl->tpl_vars['extra']->value == 'access-granted') { ?>
                <?php $_smarty_tpl->_subTemplateRender("file:acredit/modals/access-granted.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
                ?>
            <?php } ?>
        <?php } ?>
    </div>
    </body>
        </html><?php }
}
