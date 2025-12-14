<div class="" data-slimscroll-height="100%" style="height: 100%;">
    <ul class="m-0 p-0" style="list-style: none;">
        {if is_array($messenger_users)}
            {foreach from=$messenger_users item=$user}
                {include file="standard/messenger/assets/user.tpl"}
            {/foreach}
        {else}
        {/if}
    </ul>
</div>