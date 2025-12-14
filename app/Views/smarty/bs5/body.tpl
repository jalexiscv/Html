<div class="wrapper">
    {if $page_template=="c0"}
        {include file="assets/main.tpl"}
    {elseif $page_template=="signin"}
        {include file="assets/session/signin/index.tpl"}
    {else}
        {include file="assets/sidebar.tpl"}
        {include file="assets/main.tpl"}
        {if $loggedin}
            {if isset($messenger) And $messenger==true}
                {include file="assets/rightbar.tpl"}
            {/if}
        {else}
            {include file="assets/rightsignin.tpl"}
        {/if}
    {/if}
</div>

