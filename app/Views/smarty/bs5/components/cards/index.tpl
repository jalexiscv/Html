{if isset($type)}
    {if $type=="normal"}
        {include file="components/cards/types/normal.tpl"}
    {elseif $type=="centered"}
        {include file="components/cards/types/centered.tpl"}
    {elseif $type=="uploader"}
        {include file="components/cards/types/uploader.tpl"}
    {elseif $type=="table"}
        {include file="components/cards/types/table.tpl"}
    {elseif $type=="dimension"}
        {include file="components/cards/types/dimension.tpl"}
    {else}
        {include file="components/cards/unkonow.tpl"}
    {/if}
{else}
    {include file="components/cards/undefined.tpl"}
{/if}