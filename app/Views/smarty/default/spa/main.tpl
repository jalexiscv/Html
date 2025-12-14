<div class="main-container-white">
    {include file="_sidebar.tpl"}
    <div role="main" class="main-content {$main_template}">
        <div class="d-none content-nav mb-1 bgc-grey-l4">
            <div class="d-flex justify-content-between align-items-center">
                <ol class="breadcrumb pl-2">
                    <li class="breadcrumb-item active text-grey">
                        <i class="fa fa-home text-dark-m3 mr-1"></i>
                        <a class="text-blue" href="#">
                            Home
                        </a>
                    </li>

                    <li class="breadcrumb-item active text-grey-d1">Dashboard</li>
                </ol>

                <div class="nav-search">
                    <form class="form-search">
                        <span class="d-inline-flex align-items-center">
                            <input type="text" placeholder="Search ..."
                                   class="form-control pr-4 form-control-sm radius-1 brc-info-m2 text-grey"
                                   autocomplete="off"/>
                            <i class="fa fa-search text-info-m1 ml-n4"></i>
                        </span>
                    </form>
                </div><!-- /.nav-search -->
            </div>
        </div><!-- breadcrumbs -->
        {if $main_template=="c8c4"}
            {include file="mains/_c8c4.tpl"}
        {elseif $main_template=="spa-general"}
            {include file="spa/mains/general.tpl"}
        {elseif $main_template=="spa-white"}
            {include file="spa/mains/white.tpl"}
        {elseif $main_template=="spa-white2"}
            {include file="spa/mains/white2.tpl"}
        {elseif $main_template=="spa-rose"}
            {include file="spa/mains/rose.tpl"}
        {elseif $main_template=="spa-signup"}
            {include file="spa/mains/signup.tpl"}
        {elseif $main_template=="spa-basic"}
            {include file="spa/mains/basic.tpl"}
        {elseif $main_template=="spa-login"}
            {include file="spa/mains/login.tpl"}
        {else}
            {include file="spa/mains/c0c0.tpl"}
        {/if}

        {if $user!="anonymous" && $main_template!="spa-signup"}
            {include file="spa/footers.tpl"}
        {/if}

    </div><!-- /main -->
    <!-- app-modal-settings.tpl -->
</div><!-- /.main-container //-->
