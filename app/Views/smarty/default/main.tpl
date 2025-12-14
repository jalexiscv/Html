<div class="main-container">
    {include file="_sidebar.tpl"}
    <div role="main" class="main-content">
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
        {elseif $main_template=="c10c2"}
            {include file="mains/_c10c2.tpl"}
        {elseif $main_template=="c9c3"}
            {include file="mains/_c9c3.tpl"}
        {elseif $main_template=="c12"}
            {include file="mains/_c12.tpl"}
        {elseif $main_template=="c12b"}
            {include file="mains/_c12b.tpl"}
        {elseif $main_template=="user-profile"}
            {include file="users/profile.tpl"}
        {else}
            {include file="mains/_c0c0.tpl"}
        {/if}
        {include file="footers.tpl"}
    </div><!-- /main -->
    <!-- app-modal-settings.tpl -->
</div><!-- /.main-container //-->
