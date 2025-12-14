<?php
/* Smarty version 3.1.36, created on 2020-11-08 07:39:01
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\mains\_c9c3.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa7e6e55fcb70_55289575',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            'b7638c53cd850d160856841ef98b72375091fdb2' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\mains\\_c9c3.tpl',
                    1 => 1603470385,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5fa7e6e55fcb70_55289575(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '13023294015fa7e6e55fa278_91800382';
        ?>
        <div class="page-content container">
            <?php if ((isset($_smarty_tpl->tpl_vars['page_header']->value))) { ?>
                <?php echo $_smarty_tpl->tpl_vars['page_header']->value; ?>

            <?php } ?>
            <div class="h-1 my-1"></div>
            <div class="row">
                <div class="col-lg-9 pr-lg-0">
                    <?php echo $_smarty_tpl->tpl_vars['main']->value; ?>

                </div>
                <div class="col-lg-3 mt-4 mt-lg-0">
                    <?php echo $_smarty_tpl->tpl_vars['right']->value; ?>

                </div>
            </div>
        </div>
    <?php }
}
