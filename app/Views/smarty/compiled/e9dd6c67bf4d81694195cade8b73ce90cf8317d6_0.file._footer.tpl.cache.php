<?php
/* Smarty version 3.1.36, created on 2020-11-08 07:39:01
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\_footer.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa7e6e5619c71_66682332',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            'e9dd6c67bf4d81694195cade8b73ce90cf8317d6' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\_footer.tpl',
                    1 => 1604196739,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5fa7e6e5619c71_66682332(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '20094014435fa7e6e56143f7_20432967';
        if ('plugin_tables') {
            echo '<script'; ?>
            type="text/javascript" src="<?php echo base_url("themes/default/node_modules/tableexport.jquery.plugin/tableExport.min.js"); ?>
            "><?php echo '</script'; ?>
            >
            <?php echo '<script'; ?>
            type="text/javascript" src="<?php echo base_url("themes/default/node_modules/tableexport.jquery.plugin/libs/FileSaver/FileSaver.min.js"); ?>
            "><?php echo '</script'; ?>
            >
            <?php echo '<script'; ?>
            type="text/javascript" src="<?php echo base_url("themes/default/node_modules/bootstrap-table/dist/bootstrap-table.min.js"); ?>
            "><?php echo '</script'; ?>
            >
            <?php echo '<script'; ?>
            type="text/javascript" src="<?php echo base_url("themes/default/node_modules/bootstrap-table/dist/extensions/export/bootstrap-table-export.js"); ?>
            "><?php echo '</script'; ?>
            >
            <?php echo '<script'; ?>
            type="text/javascript" src="<?php echo base_url("themes/default/node_modules/bootstrap-table/dist/extensions/print/bootstrap-table-print.js"); ?>
            "><?php echo '</script'; ?>
            >
            <?php echo '<script'; ?>
            type="text/javascript" src="<?php echo base_url("themes/default/node_modules/bootstrap-table/dist/locale/bootstrap-table-es-ES.js"); ?>
            "><?php echo '</script'; ?>
            >
        <?php }
        echo '<script'; ?>
        type="text/javascript" src="<?php echo base_url("themes/default/dist/js/ace.js"); ?>
        "><?php echo '</script'; ?>
        >
        <?php echo '<script'; ?>
        type="text/javascript" src="<?php echo base_url("themes/default/assets/js/demo.js"); ?>
        "><?php echo '</script'; ?>
        >

        <?php echo '<script'; ?>
        type="text/javascript" src="<?php echo base_url("themes/assets/javascripts/Higgs/reactions.js"); ?>
        "><?php echo '</script'; ?>
        >


        <?php if ((isset($_smarty_tpl->tpl_vars['ads']->value))) {
        echo '<script'; ?>
        >
        (adsbygoogle = window.adsbygoogle || []).push({});
        <?php echo '</script'; ?>
        >
    <?php }
    }
}
