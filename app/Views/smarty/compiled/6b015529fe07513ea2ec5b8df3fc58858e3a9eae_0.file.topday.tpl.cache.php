<?php
/* Smarty version 3.1.36, created on 2020-11-08 07:37:42
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\social\posts\topday.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa7e696423634_24092935',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '6b015529fe07513ea2ec5b8df3fc58858e3a9eae' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\social\\posts\\topday.tpl',
                    1 => 1604197207,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5fa7e696423634_24092935(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '2699088905fa7e696409874_46832711';
        ?>

        <?php if (is_desktop()) { ?>
        <?php if ((isset($_smarty_tpl->tpl_vars['ads']->value))) { ?>
            <div class="card mb-2">
                <!-- Anuncio gráfico cuadrado 8716747948 -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-1567513595638732"
                     data-ad-slot="8716747948"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
            </div>
        <?php }
    } ?>

        <?php if (is_array($_smarty_tpl->tpl_vars['topday']->value)) { ?>
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
                            <a href="/social/semantic/<?php echo $_smarty_tpl->tpl_vars['post']->value["semantic"]; ?>
.html" class="inline">
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
                            [ <a href="/social/semantic/<?php echo $_smarty_tpl->tpl_vars['post']->value["semantic"]; ?>
.html" class="inline"><?php echo lang("App.Read-More"); ?>
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
