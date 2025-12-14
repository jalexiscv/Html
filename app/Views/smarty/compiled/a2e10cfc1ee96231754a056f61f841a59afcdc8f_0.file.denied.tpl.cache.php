<?php
/* Smarty version 3.1.36, created on 2020-11-08 07:36:45
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\alerts\denied.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa7e65dabf7b7_74907491',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            'a2e10cfc1ee96231754a056f61f841a59afcdc8f' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\alerts\\denied.tpl',
                    1 => 1597365324,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5fa7e65dabf7b7_74907491(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '6741930255fa7e65dab70e9_38961159';
        ?>
        <div class="card text-white bg-danger mb-2 mr-0 ml-0">
            <div class="card-header">
                <h4 class="m-0 p-0">
                    <?php echo $_smarty_tpl->tpl_vars['title']->value; ?>

                </h4>
            </div>
            <div class="card-body d-sm-flex align-items-center justify-content-start">
                <i class="fas fa-exclamation-triangle fa-4x text-warning-d4 float-rigt mr-4 mt-1"></i>
                <div class="text-100 line-height-n">
                    <p><?php echo $_smarty_tpl->tpl_vars['message']->value; ?>
                    </p>
                    <?php if ($_smarty_tpl->tpl_vars['permissions']->value) { ?>
                        <p><b><?php echo lang("App.Permissions"); ?>
                            </b>: <?php echo $_smarty_tpl->tpl_vars['permissions']->value; ?>
                        </p>
                    <?php } ?>
                </div>

            </div>
            <div class="card-footer text-right">
                <?php if ($_smarty_tpl->tpl_vars['continue']->value) { ?>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['continue']->value; ?>
" class="btn btn-md btn-secondary"><?php echo lang("App.Continue"); ?>
                    </a>
                <?php } ?>
                <?php if ((isset($_smarty_tpl->tpl_vars['help']->value))) { ?>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['help']->value; ?>
" class="btn btn-md btn-secondary"><?php echo lang("App.Help"); ?>
                    </a>
                <?php } ?>
            </div>
        </div>
    <?php }
}
