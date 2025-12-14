{nocache}
    <div class="card  {if isset($class) AND $class!==false }{$class}{/if} w-100 mb-3">
        {include file="assets/card/header.tpl"}
        {if (isset($image) AND $image==TRUE) }
            <img src="{$image}" class="card-img-top p-5" alt="...">
        {/if}
        {if (isset($body) AND $body==TRUE) }
            <div class="card-body ">
                {if isset($alerts) AND $alerts!==false}
                    {$alerts}
                {/if}
                {if isset($body) AND $body!==false}
                    {$body}
                {/if}
            </div>
        {/if}
        {if isset($footer) AND $footer!==false }
            <div class="card-footer ">
                {$footer}
            </div>
        {/if}
    </div>
{/nocache}