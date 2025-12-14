<?php
/* Smarty version 3.1.36, created on 2020-11-08 07:39:01
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\social\posts\post.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa7e6e54e3f45_91932174',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            'a62cdfb44a7b86b7337433e558b2f3c0dc924481' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\social\\posts\\post.tpl',
                    1 => 1604229514,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(
            'file:social/posts/content.tpl' => 1,
            'file:social/posts/keywords.tpl' => 1,
            'file:social/posts/complementary.tpl' => 1,
            'file:social/posts/locals.tpl' => 1,
        ),
), false)) {
    function content_5fa7e6e54e3f45_91932174(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '7110286715fa7e6e54d8604_36565282';
        ?>
        <div class="row p-0 -m-0">
            <?php if (is_mobile()) { ?>
                <div
                        style="width:480px;height:320px;display: block;overflow: hidden;position: relative;top: -21px;padding: 0px;margin: 0;left: 0px;">
                    <ins class="adsbygoogle" style="display:block"
                         data-ad-client="ca-pub-1567513595638732"
                         data-ad-slot="2152173748"
                         data-ad-format="auto"
                         data-full-width-responsive="true">
                    </ins>
                </div>
            <?php } else { ?>
                <div
                        style="margin-bottom: 15px;margin-left: 15px; margin-right: 15px; padding-top: 0px;width:100%;height:240px;display: block;overflow: hidden;position: relative;top: 0px;">
                    <ins class="adsbygoogle" style="display:block"
                         data-ad-client="ca-pub-1567513595638732"
                         data-ad-slot="2152173748"
                         data-ad-format="auto"
                         data-full-width-responsive="true">
                    </ins>
                </div>
            <?php } ?>
        </div>

        <div class="row">
        <div class="col-md-9 col-sm-12 ">
            <?php $_smarty_tpl->_subTemplateRender("file:social/posts/content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
            ?>
            <?php $_smarty_tpl->_subTemplateRender("file:social/posts/keywords.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
            ?>
            <?php $_smarty_tpl->_subTemplateRender("file:social/posts/complementary.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
            ?>
        </div>
        <div class="col-md-3 d-none d-xl-block d-lg-block pl-md-0">
            <?php $_smarty_tpl->_subTemplateRender("file:social/posts/locals.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
            ?>
        </div>
        </div><?php }
}
