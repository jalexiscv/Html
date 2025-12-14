<div class="card  {if isset($class) AND $class!==false }{$class}{/if} w-100 mb-3">
    {include file="assets/card/header.tpl"}
    {if isset($image)}
        <img src="{$image}" class="card-img-top p-5" alt="...">
    {/if}
    <div class="card-body ">
        {if isset($alerts) AND $alerts!==false}
            {$alerts}
        {/if}
        {if isset($text) AND $text!==false}
            <p class="card-text">{$text}</p>
        {/if}
        {$body}
        {table
        id=$table['id']
        data-url=$table['data-url']
        cols=$table['cols']
        buttons=$table['buttons']
        data-page-size=$table['data-page-size']
        data-side-pagination=$table['data-side-pagination']
        data-show-columns=true
        data-show-refresh=true
        data-show-fullscreen=true
        stickyHeader=true
        }
    </div>
    {if isset($footer) AND $footer!==false }
        <div class="card-footer text-muted">
            {$footer}
        </div>
    {/if}
</div>