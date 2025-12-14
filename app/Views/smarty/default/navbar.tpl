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