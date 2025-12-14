<?php
/* Smarty version 3.1.36, created on 2020-11-06 04:32:51
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\disa\scores\autodiagnostic.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa518437fd2f1_54766674',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '7bd40809cfccaf06623cacb52f90bc2c336c8f5c' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\disa\\scores\\autodiagnostic.tpl',
                    1 => 1603317918,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5fa518437fd2f1_54766674(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '17560548415fa518437de086_99602423';
        ?>
        <div class="card mb-1">
        <div class="card-header p-1">
            <h5 class="card-header-title p-1  m-0 opacity-3">Puntaje Actual</h5>
        </div>
        <div class="card-body">
            <!-- [score] //-->
            <div class="px-2 py-2 py-lg-3 d-flex pos-rel mx-1 justify-content-start justify-content-lg-center">
                <div class="d-none d-lg-block border-r-1 brc-secondary-l1 position-rc h-75"></div>
                <div class="d-sm-none mb-n1 border-b-1 brc-secondary-l1 position-bc w-90"></div>
                <div class="pl-1">
        <span class="d-inline-block bgc-success-m1 p-3 radius-round text-center">
        <i class="fa fa-dice-d6 text-white text-180 w-4"></i>
        </span>
                </div>
                <div class="pl-25">
                    <div class="d-flex align-items-center justify-content-between justify-content-md-start">
        <span class="text-secondary-d3 text-160 mr-4"><?php echo $_smarty_tpl->tpl_vars['score']->value; ?>
</span>
                    </div>
                    <div class="text-nowrap">Valoración promedio</div>
                </div>
            </div>
            <!-- [/score] //-->
        </div>
        </div><?php }
}
