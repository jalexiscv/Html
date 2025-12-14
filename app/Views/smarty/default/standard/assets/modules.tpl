{if isset($styles)}
    {if is_array($styles)}
        <!-- module css //-->
        {foreach from=$styles item=$style}
            <link href="{base_url($style)}" rel="stylesheet" type="text/css"/>
        {/foreach}
    {/if}
{/if}