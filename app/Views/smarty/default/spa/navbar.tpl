{if $main_template=="spa-general"||$main_template=="c8c4"}
    <nav class="navbar navbar-expand-lg navbar-fixed navbar-default">
        <div class="navbar-inner">
            {include file="components/navbar-intro.tpl"}
            {if $loggedin}
                {include file="components/navbar-content-loggedin.tpl"}
                {include file="components/navbar-menu-loggedin.tpl"}
            {else}
                {include file="components/navbar-content.tpl"}
                {include file="components/navbar-menu.tpl"}
            {/if}
        </div>
    </nav>
    {if $main_template=="spa-general"}
        <img src="/themes/assets/images/header/spa-border-header.png" alt=""
             style="position: fixed;top: 63px;z-index: 9999;width: 100%;">
    {/if}
{/if}