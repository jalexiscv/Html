<?php
/* Smarty version 3.1.36, created on 2020-11-08 07:37:42
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\social\posts\small.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa7e696458db5_89566341',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '849354601ca863d38314f3226d0279195ac6e25b' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\social\\posts\\small.tpl',
                    1 => 1603566631,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5fa7e696458db5_89566341(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '9509451475fa7e6964332e8_89625373';
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
                            <a href="/social/semantic/<?php echo $_smarty_tpl->tpl_vars['post']->value["semantic"]; ?>
.html" class="inline">
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

                            [ <a href="/social/semantic/<?php echo $_smarty_tpl->tpl_vars['post']->value["semantic"]; ?>
.html" class="inline"><?php echo lang("App.Read-More"); ?>
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
        } ?>

        <?php if ((isset($_smarty_tpl->tpl_vars['offset']->value))) { ?>
        <!-- Pagination -->
        <?php $_smarty_tpl->_assignInScope('previus', $_smarty_tpl->tpl_vars['offset']->value - 20); ?>
        <?php $_smarty_tpl->_assignInScope('next', $_smarty_tpl->tpl_vars['offset']->value + 20); ?>
        <ul class="pagination justify-content-center">
            <li class="page-item"><a href="/social/index?offset=<?php echo $_smarty_tpl->tpl_vars['previus']->value; ?>
" class="page-link"><i class="fas fa-chevron-left"></i></a></li>
            <?php
            $_smarty_tpl->tpl_vars['__smarty_section_pagination'] = new Smarty_Variable(array());
            if (true) {
                for ($__section_pagination_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pagination']->value['index'] = 1; $__section_pagination_0_iteration <= 5; $__section_pagination_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pagination']->value['index']++) {
                    ?>
                    <?php $_smarty_tpl->_assignInScope('position', (isset($_smarty_tpl->tpl_vars['__smarty_section_pagination']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_pagination']->value['index'] : null) * 20); ?>
                    <li class="page-item"><a
                                href="/social/index?offset=<?php echo $_smarty_tpl->tpl_vars['position']->value; ?>
" class="page-link"><?php echo $_smarty_tpl->tpl_vars['position']->value / 20; ?>
                        </a></li>
                    <?php
                }
            }
            ?>
            <li class="page-item"><a href="/social/index?offset=<?php echo $_smarty_tpl->tpl_vars['next']->value; ?>
" class="page-link"><i class="fas fa-chevron-right"></i></a></li>
        </ul>
    <?php }
    }
}
