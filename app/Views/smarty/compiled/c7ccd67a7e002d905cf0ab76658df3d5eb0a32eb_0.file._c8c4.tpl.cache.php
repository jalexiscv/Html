<?php
/* Smarty version 3.1.36, created on 2020-10-02 12:18:39
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\_c8c4.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5f7760efa74652_54556794',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            'c7ccd67a7e002d905cf0ab76658df3d5eb0a32eb' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\_c8c4.tpl',
                    1 => 1599116415,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5f7760efa74652_54556794(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '4863086085f7760efa72d89_20044281';
        ?>
        <div class="page-content container">
        <?php if ((isset($_smarty_tpl->tpl_vars['page_header']->value))) { ?>
        <?php echo $_smarty_tpl->tpl_vars['page_header']->value; ?>

    <?php } ?>
        <div class="h-1 my-1"></div>
        <div class="row">
            <div class="col-lg-8">
                <?php echo $_smarty_tpl->tpl_vars['main']->value; ?>

            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
                <?php echo $_smarty_tpl->tpl_vars['right']->value; ?>

            </div>
        </div>
        </div><?php }
}
