<?php
/* Smarty version 3.1.36, created on 2020-10-19 09:52:44
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\posts\categories.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5f8da83cc84698_71010701',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '48862a4351c09b5fcf468a1c7aca150bace1a8a9' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\posts\\categories.tpl',
                    1 => 1602878930,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5f8da83cc84698_71010701(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '13155621275f8da83cc79df9_03330769';
        if (is_array($_smarty_tpl->tpl_vars['topday']->value)) { ?>
            <?php
            $_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['topday']->value, 'post');
            $_smarty_tpl->tpl_vars['post']->do_else = true;
            if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['post']->value) {
                $_smarty_tpl->tpl_vars['post']->do_else = false;
                ?>
                <!-- Card -->
                <?php if ((isset($_smarty_tpl->tpl_vars['post']->value["post"]))) { ?>
                    <div class="card mb-2">
                        <?php if ((isset($_smarty_tpl->tpl_vars['post']->value["cover"])) && !is_array($_smarty_tpl->tpl_vars['post']->value["cover"])) { ?>
                            <div class="view overlay">
                                <a href="/social/posts/view/<?php echo $_smarty_tpl->tpl_vars['post']->value["post"]; ?>
" class="inline">
                                    <img class="card-img-top"
                                         src="<?php echo $_smarty_tpl->tpl_vars['post']->value["cover"]; ?>
" alt="">
                                </a>
                            </div>
                        <?php } ?>
                        <!-- Card content -->
                        <div class="card-body pt-2 pb-0 pl-2 pr-2">
                            <!-- Text -->
                            <p class="small-post-content">
                                <?php if ((isset($_smarty_tpl->tpl_vars['post']->value["title"]))) { ?>
                                    <?php echo $_smarty_tpl->tpl_vars['post']->value["title"]; ?>

                                <?php } ?>
                                [ <a
                                        href="/social/posts/view/<?php echo $_smarty_tpl->tpl_vars['post']->value["post"]; ?>
" class="inline"><?php echo lang("App.Read-More"); ?>
                                </a> ]
                            </p>
                        </div>
                    </div>
                <?php } ?>
                <?php
            }
            $_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
        }
    }
}
