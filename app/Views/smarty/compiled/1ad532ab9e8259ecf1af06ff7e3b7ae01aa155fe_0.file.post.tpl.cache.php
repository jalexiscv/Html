<?php
/* Smarty version 3.1.36, created on 2020-10-18 08:36:08
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\posts\post.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5f8c44c8e0d146_75799639',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '1ad532ab9e8259ecf1af06ff7e3b7ae01aa155fe' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\posts\\post.tpl',
                    1 => 1602446046,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5f8c44c8e0d146_75799639(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '20572852645f8c44c8de9f51_65141047';
        ?>
        <div class="card post">
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
"><i class="far fa-pen-nib"></i> <?php echo lang("App.Edit"); ?>
                            </a>
                            <a class="dropdown-item"
                               href="/social/posts/delete/<?php echo $_smarty_tpl->tpl_vars['pid']->value; ?>
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
                <div class="embed">
                    <?php echo $_smarty_tpl->tpl_vars['video']->value; ?>

                </div>
            <?php } ?>
            <!-- /.card-header -->
            <div class="card-body p-2">
                <h2 class="card-title post-title"><?php echo $_smarty_tpl->tpl_vars['title']->value; ?>
                </h2>
                <div class="meta-info pb-1"><?php echo $_smarty_tpl->tpl_vars['by']->value; ?>
                    , <?php echo $_smarty_tpl->tpl_vars['ago']->value; ?>
                </div>
                <div class="content" style="overflow: hidden">
                    <div class="mr-xl-2" style="float: left">
                        <ins class="adsbygoogle"
                             style="display:inline-block;width:320px;height:240px"
                             data-ad-layout="in-article"
                             data-ad-format="fluid"
                             data-ad-client="ca-pub-1567513595638732"
                             data-ad-slot="4395193700"></ins>
                    </div>
                    <?php echo $_smarty_tpl->tpl_vars['content']->value; ?>

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
        ><?php }
}
