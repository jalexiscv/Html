{if isset($main_template)}
    {if $main_template=='login'}
        {include file="assets/login.tpl"}
    {elseif $main_template=='normal' }
        {include file="assets/normal.tpl"}
    {elseif $main_template=='white' }
        {include file="assets/white.tpl"}
    {elseif $main_template=='shimmering' }
        {include file="assets/shimmering.tpl"}
    {elseif $main_template=='pink' }
        {include file="assets/pink.tpl"}
    {elseif $main_template=='client' }
        {include file="assets/client.tpl"}
    {elseif $main_template=='profile' }
        {include file="assets/profile.tpl"}
    {elseif $main_template=='catalog' }
        {include file="assets/catalog.tpl"}
    {elseif $main_template=='signout' }
        {include file="assets/signout.tpl"}
    {else}
        {include file="assets/default.tpl"}
    {/if}
{/if}