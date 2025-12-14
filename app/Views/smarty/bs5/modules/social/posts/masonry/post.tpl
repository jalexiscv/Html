{if is_array($posts)}
    {foreach from=$posts item=post}
        <div class="col-12 col-masonry">
            <div class="card ">
                <div class="card-header">
                    {get_ago($post["date"],$post["time"])}
                </div>
                <a href="{$post["link"]}" class="inline">
                    <img src="{$post["thumbnail"]}"
                         class="card-img-top article-image-cover" alt="...">
                </a>
                <div class="card-body">
                    <h3 class="card-title ">{$post["title"]}</h3>
                    <p class="card-text ">{$post["description"]}</p>
                </div>
                <div class="card-footer  text-muted">
                    <a href="{$post["link"]}">Leer más</a>
                </div>
            </div>
        </div>
    {/foreach}
{/if}





