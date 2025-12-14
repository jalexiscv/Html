<?php
/* Smarty version 3.1.36, created on 2020-11-08 07:39:01
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\social\posts\content.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa7e6e54fdd11_21588806',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '1974776918c658212f3da5eb6c10b49c9bf778fa' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\social\\posts\\content.tpl',
                    1 => 1604204087,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(
            'file:social/posts/video.tpl' => 1,
        ),
), false)) {
    function content_5fa7e6e54fdd11_21588806(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '21402472995fa7e6e54f2bb2_50239299';
        ?>
        <div class="card post mb-2">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="far fa-calendar-alt"></i> <?php echo $_smarty_tpl->tpl_vars['date']->value; ?>

                    <i class="far fa-alarm-clock"></i> <?php echo $_smarty_tpl->tpl_vars['time']->value; ?>

                </h5>
                <div class="card-toolbar">
                    <div class="dropdown">
                        <a href="" data-action="settings" data-toggle="dropdown" class="card-toolbar-btn text-blue-m1">
                            <i class="fa fa-bars"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-caret mr-n3 dropdown-animated">
                            <a class="dropdown-item"
                               href="/social/posts/edit/<?php echo $_smarty_tpl->tpl_vars['pid']->value; ?>
/?time=<?php echo time(); ?>
"><i class="far fa-pen-nib"></i> <?php echo lang("App.Edit"); ?>
                            </a>
                            <a class="dropdown-item"
                               href="/social/posts/delete/<?php echo $_smarty_tpl->tpl_vars['pid']->value; ?>
/?time=<?php echo time(); ?>
"><i class="far fa-trash-alt"></i> <?php echo lang("App.Delete"); ?>
                            </a>
                            <!--<li class="divider"></li>//-->
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($_smarty_tpl->tpl_vars['cover_visible']->value && !$_smarty_tpl->tpl_vars['video']->value) { ?>
                <img class="card-img-top" src="<?php echo $_smarty_tpl->tpl_vars['cover']->value; ?>
" alt="">
            <?php } ?>
            <?php if ($_smarty_tpl->tpl_vars['video']->value) { ?>
                <?php $_smarty_tpl->_subTemplateRender("file:social/posts/video.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
                ?>
            <?php } ?>
            <!-- /.card-header -->
            <div class="card-body p-2">
                <h2 class="card-title post-title"><?php echo $_smarty_tpl->tpl_vars['title']->value; ?>
                </h2>
                <div class="meta-info pb-1"><?php echo $_smarty_tpl->tpl_vars['by']->value; ?>
                    , <?php echo $_smarty_tpl->tpl_vars['ago']->value; ?>
                </div>
                <div class="content" style="overflow: hidden">
                    <?php if ((isset($_smarty_tpl->tpl_vars['city_name']->value))) { ?>
                        <span><b><?php echo $_smarty_tpl->tpl_vars['city_name']->value; ?>
</b>, <?php echo $_smarty_tpl->tpl_vars['date_textual']->value; ?>
</span>
                    <?php } ?>
                    <?php echo $_smarty_tpl->tpl_vars['content']->value; ?>

                    <?php if ((isset($_smarty_tpl->tpl_vars['source']->value)) && (isset($_smarty_tpl->tpl_vars['source_alias']->value))) { ?>
                        <?php if (!empty($_smarty_tpl->tpl_vars['source_alias']->value)) { ?>
                            <p>
                                <b>Fuente</b>:
                                <a href="<?php echo $_smarty_tpl->tpl_vars['source']->value; ?>
" target="_blank" rel="nofollow"><?php echo $_smarty_tpl->tpl_vars['source_alias']->value; ?>
                                </a>
                            </p>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-muted"></div>
        </div>

        <?php echo '<script'; ?>
        >
        $(document).ready(function(){
        $.post("/social/posts/ajax/count/<?php echo $_smarty_tpl->tpl_vars['pid']->value; ?>
        ",{
        '<?php echo csrf_token(); ?>
        ': "<?php echo csrf_hash(); ?>
        ",
        'post': "<?php echo $_smarty_tpl->tpl_vars['pid']->value; ?>
        "
        },function(data, status){

        });
        });
        <?php echo '</script'; ?>
        >


    <?php }
}
