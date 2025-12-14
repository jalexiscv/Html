<?php
/* Smarty version 3.1.36, created on 2020-11-07 19:59:56
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\mains\_c8c4.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa7430c705ca2_51622307',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '680bca299b42d526e9ae1df51ba65630f0ec40bc' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\mains\\_c8c4.tpl',
                    1 => 1603466647,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5fa7430c705ca2_51622307(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '20370188085fa7430c7048a0_99582614';
        ?>
        <div class="page-content container">
        <?php if ((isset($_smarty_tpl->tpl_vars['page_header']->value))) { ?>
        <?php echo $_smarty_tpl->tpl_vars['page_header']->value; ?>

    <?php } ?>
        <div class="h-1 my-1"></div>
        <div class="row">
            <div class="col-lg-8 pr-lg-0">
                <?php echo $_smarty_tpl->tpl_vars['main']->value; ?>

            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
                <?php echo $_smarty_tpl->tpl_vars['right']->value; ?>

            </div>
        </div>
        </div><?php }
}
