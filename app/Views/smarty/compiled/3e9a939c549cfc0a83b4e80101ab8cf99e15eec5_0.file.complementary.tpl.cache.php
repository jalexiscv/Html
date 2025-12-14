<?php
/* Smarty version 3.1.36, created on 2020-11-08 07:39:01
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\social\posts\complementary.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa7e6e55247f7_72331345',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '3e9a939c549cfc0a83b4e80101ab8cf99e15eec5' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\social\\posts\\complementary.tpl',
                    1 => 1603926380,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5fa7e6e55247f7_72331345(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '7809156325fa7e6e551a8d4_05575837';
        ?>
        <div class="row">
            <div class="col-xl-6 col-sm-12 pr-xl-1 pr-sm-1">
                <?php if ((isset($_smarty_tpl->tpl_vars['regionals']->value))) { ?>
                    <?php
                    $_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['regionals']->value, 'post');
                    $_smarty_tpl->tpl_vars['post']->do_else = true;
                    if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['post']->value) {
                        $_smarty_tpl->tpl_vars['post']->do_else = false;
                        ?>
                        <article class="card card-full hover-a mb-2">
                            <div class="row">
                                <div class="col-4 col-md-4  pr-0 pr-md-0">
                                    <div class="image-wrapper">
                                        <a href="/social/semantic/<?php echo $_smarty_tpl->tpl_vars['post']->value["semantic"]; ?>
.html">
                                            <img src="<?php echo $_smarty_tpl->tpl_vars['post']->value["cover"]; ?>
" class="img-fluid-news" alt="" width="115" height="80">
                                            <!-- post type -->
                                        </a>
                                    </div>
                                </div>
                                <div class="col-8 col-md-8">
                                    <div class="card-body pt-2 pl-0 pr-2 pb-2">
                                        <h3 class="card-title h6 h5-sm h6-lg small-news-text">
                                            <a href="/social/semantic/<?php echo $_smarty_tpl->tpl_vars['post']->value["semantic"]; ?>
.html">
                                                <?php if ((isset($_smarty_tpl->tpl_vars['post']->value["title"]))) { ?>
                                                    <?php echo $_smarty_tpl->tpl_vars['post']->value["title"]; ?>

                                                <?php } ?>
                                            </a>
                                        </h3>
                                        <div class="card-text small text-muted">
                                            <time class="news-date"
                                                  datetime=""><?php echo $_smarty_tpl->tpl_vars['post']->value["date"]; ?>
                                                <?php echo $_smarty_tpl->tpl_vars['post']->value["time"]; ?>
                                            </time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <?php
                    }
                    $_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1); ?>
                <?php } ?>
            </div>
            <div class="col-xl-6 col-sm-12 pl-xl-1 pl-sm-1">
                <?php if ((isset($_smarty_tpl->tpl_vars['nationals']->value)) && is_array($_smarty_tpl->tpl_vars['nationals']->value)) { ?>
                    <?php
                    $_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['nationals']->value, 'post');
                    $_smarty_tpl->tpl_vars['post']->do_else = true;
                    if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['post']->value) {
                        $_smarty_tpl->tpl_vars['post']->do_else = false;
                        ?>
                        <article class="card card-full hover-a mb-2">
                            <div class="row">
                                <div class="col-4 col-md-4  pr-0 pr-md-0">
                                    <div class="image-wrapper">
                                        <a href="/social/semantic/<?php echo $_smarty_tpl->tpl_vars['post']->value["semantic"]; ?>
.html">
                                            <img src="<?php echo $_smarty_tpl->tpl_vars['post']->value["cover"]; ?>
" class="img-fluid-news" alt="" width="115" height="80">
                                            <!-- post type -->
                                        </a>
                                    </div>
                                </div>
                                <div class="col-8 col-md-8">
                                    <div class="card-body pt-2 pl-0 pr-2 pb-2">
                                        <h3 class="card-title h6 h5-sm h6-lg small-news-text">
                                            <a href="/social/semantic/<?php echo $_smarty_tpl->tpl_vars['post']->value["semantic"]; ?>
.html">
                                                <?php if ((isset($_smarty_tpl->tpl_vars['post']->value["title"]))) { ?>
                                                    <?php echo $_smarty_tpl->tpl_vars['post']->value["title"]; ?>

                                                <?php } ?>
                                            </a>
                                        </h3>
                                        <div class="card-text small text-muted">
                                            <time class="news-date"
                                                  datetime=""><?php echo $_smarty_tpl->tpl_vars['post']->value["date"]; ?>
                                                <?php echo $_smarty_tpl->tpl_vars['post']->value["time"]; ?>
                                            </time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <?php
                    }
                    $_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1); ?>
                <?php } ?>
            </div>
        </div>


    <?php }
}
