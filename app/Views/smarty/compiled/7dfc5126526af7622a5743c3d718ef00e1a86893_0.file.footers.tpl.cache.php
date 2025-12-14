<?php
/* Smarty version 3.1.36, created on 2020-11-08 07:39:01
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\footers.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa7e6e5609434_05586972',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '7dfc5126526af7622a5743c3d718ef00e1a86893' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\footers.tpl',
                    1 => 1603835708,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5fa7e6e5609434_05586972(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '9824565005fa7e6e5608793_62931587';
        ?>


        <footer class="footer d-none d-sm-block">
            <div class="footer-inner">
                <div class="pt-3 border-none border-t-3 brc-grey-l1 border-double text-120">
                    <span class="text-primary-m2 font-bolder ">Higgs</span>
                    <span class="text-muted">Application &copy; 2020</span>

                    <span class="mx-3 action-buttons">
                        <a href="#" class="text-blue2-m3 text-140"><i class="fab fa-twitter-square"></i></a>
                        <a href="#" class="text-blue-d1 text-140"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-orange text-140"><i class="fa fa-rss-square"></i></a>
                    </span>
                </div>
            </div><!-- .footer-inner -->

            <div class="footer-tools">
                <a id="btn-scroll-up" href="#" class="btn-scroll-up btn btn-dark btn-smd mb-2 mr-2">
                    <i class="fa fa-angle-double-up mx-1"></i>
                </a>
            </div>
        </footer>


        <!-- footer toolbox for mobile view -->
        <footer class="d-sm-none footer footer-sm footer-fixed">
            <div class="footer-inner">

                <div
                        class="btn-group d-flex h-100 mx-2 border-x-1 border-t-2 brc-primary-m3 bgc-default-l4 radius-t-1 shadow">
                    <button class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0">
                        <i class="fas fa-sliders-h text-blue-m1 text-120"></i>
                    </button>

                    <button class="btn btn-outline-purple btn-h-lighter-purple btn-a-lighter-purple border-0">
                        <i class="fa fa-plus-circle text-purple-m2 text-120"></i>
                    </button>

                    <button class="btn btn-outline-warning btn-h-lighter-warning btn-a-lighter-warning border-0"
                            data-toggle="collapse" data-target="#navbarSearch" aria-controls="navbarSearch"
                            aria-expanded="false" aria-label="Toggle navbar search">
                        <i class="fa fa-search text-warning text-120"></i>
                    </button>

                    <button class="btn btn-outline-brown btn-h-lighter-brown btn-a-lighter-brown border-0 mr-0">
                        <i class="fa fa-bell text-brown-m1 text-120"></i>
                    </button>
                </div>
            </div>
        </footer><?php }
}
