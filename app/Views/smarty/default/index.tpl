{if isset($page_template)}
    {if $page_template=="page"}
        {include file="general/index.tpl"}
    {elseif $page_template=="signin"}
        {include file="signin.tpl"}
    {elseif $page_template=="welcome"}
        {include file="welcome.tpl"}
    {elseif $page_template=="page-acredit"}
        {include file="acredit/index.tpl"}
    {elseif $page_template=="page-disa"}
        {include file="disa/index.tpl"}
    {elseif $page_template=="page-spa"}
        {include file="spa/index.tpl"}
    {elseif $page_template=="page-standard"}
        {include file="standard/index.tpl"}
    {elseif $page_template=="page-social"}
        {include file="social/index.tpl"}
    {else}
        {include file="etc.tpl"}
    {/if}
{/if}