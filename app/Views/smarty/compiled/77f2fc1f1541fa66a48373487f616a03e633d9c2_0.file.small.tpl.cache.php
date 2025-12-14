<?php
/* Smarty version 3.1.36, created on 2020-10-19 09:52:44
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\posts\small.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5f8da83cc9e167_55938421',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '77f2fc1f1541fa66a48373487f616a03e633d9c2' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\posts\\small.tpl',
                    1 => 1602878593,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5f8da83cc9e167_55938421(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '4386771475f8da83cc92d29_41278618';
        if (is_array($_smarty_tpl->tpl_vars['posts']->value)) { ?>
            <?php
            $_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['posts']->value, 'post');
            $_smarty_tpl->tpl_vars['post']->do_else = true;
            if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['post']->value) {
                $_smarty_tpl->tpl_vars['post']->do_else = false;
                ?>
                <!-- Card -->
                <div class="card mb-2">
                    <?php if ($_smarty_tpl->tpl_vars['post']->value["cover"]) { ?>
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
                    <div class="card-body pb-0">
                        <!-- Small Title -->
                        <?php if ((isset($_smarty_tpl->tpl_vars['post']->value["title"]))) { ?>
                            <h4 class="card-title small-post-title"><?php echo $_smarty_tpl->tpl_vars['post']->value["title"]; ?>
                            </h4>
                        <?php } ?>
                        <!-- Text -->
                        <p class="small-post-content"><?php echo $_smarty_tpl->tpl_vars['post']->value["description"]; ?>

                            [ <a href="/social/posts/view/<?php echo $_smarty_tpl->tpl_vars['post']->value["post"]; ?>
" class="inline"><?php echo lang("App.Read-More"); ?>
                            </a> ]
                        </p>
                    </div>
                    <div class="card-footer bg-transparent"></div>
                    <ul class="social-score">
                        <?php if ($_smarty_tpl->tpl_vars['user']->value != "anonymous") { ?>
                            <li class="social-score-item"><a href="#" class="card-link"
                                                             title="<?php echo lang("App.Views"); ?>
"><i class="far fa-eye"></i> <?php echo $_smarty_tpl->tpl_vars['post']->value["short_views"]; ?>
                                </a></li>
                        <?php } ?>
                        <li class="social-score-item"><a href="#"
                                                         post="<?php echo $_smarty_tpl->tpl_vars['post']->value["post"]; ?>
" class="card-link post-reaction" title="<?php echo lang("App.Likes"); ?>
"><i class="far fa-thumbs-up"></i> <?php echo $_smarty_tpl->tpl_vars['post']->value["short_likes"]; ?>
                            </a></li>
                        <li class="social-score-item"><a href="#"
                                                         post="<?php echo $_smarty_tpl->tpl_vars['post']->value["post"]; ?>
" class="card-link" title="<?php echo lang("App.Shares"); ?>
"><i class="far fa-share-alt"></i> <?php echo $_smarty_tpl->tpl_vars['post']->value["short_shares"]; ?>
                            </a></li>
                        <li class="social-score-item"><a href="#"
                                                         post="<?php echo $_smarty_tpl->tpl_vars['post']->value["post"]; ?>
" class="card-link" title="<?php echo lang("App.Comments"); ?>
"><i class="far fa-comments"></i> <?php echo $_smarty_tpl->tpl_vars['post']->value["short_comments"]; ?>
                            </a></li>
                    </ul>
                </div>
                <!-- Card -->
                <?php
            }
            $_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
        }
    }
}
