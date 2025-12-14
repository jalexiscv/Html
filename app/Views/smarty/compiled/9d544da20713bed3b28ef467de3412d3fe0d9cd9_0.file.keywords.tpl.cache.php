<?php
/* Smarty version 3.1.36, created on 2020-11-08 07:39:01
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\social\posts\keywords.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa7e6e550dbb4_62576304',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '9d544da20713bed3b28ef467de3412d3fe0d9cd9' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\social\\posts\\keywords.tpl',
                    1 => 1603842528,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5fa7e6e550dbb4_62576304(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '4001114165fa7e6e5509e07_92335757';
        ?>
        <!-- keywords -->
        <div class="card mb-2">
        <div class="card-header">
            <h5 class="card-title">Etiquetas</h5>
        </div>
        <div class="card-body p-2">
            <?php
            $_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['keywords']->value, 'keyword');
            $_smarty_tpl->tpl_vars['keyword']->do_else = true;
            if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['keyword']->value) {
                $_smarty_tpl->tpl_vars['keyword']->do_else = false;
                ?>
                <span class="badge badge-keyword">
                <a href="/social/keywords/view/<?php echo $_smarty_tpl->tpl_vars['keyword']->value; ?>
"><?php echo $_smarty_tpl->tpl_vars['keyword']->value; ?>
</a>
            </span>
                <?php
            }
            $_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1); ?>
        </div>
        </div><?php }
}
